<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'permission:view prescriptions']);
    }

    public function index(Request $request)
    {
        $query = Prescription::with('createdBy', 'items');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('prescription_number', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%")
                    ->orWhere('doctor_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(20);
        $prescriptions->appends($request->only(['search', 'status']));

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('prescriptions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_age' => 'nullable|integer|min:0',
            'patient_contact' => 'nullable|string|max:20',
            'doctor_name' => 'required|string|max:255',
            'doctor_license' => 'nullable|string|max:50',
            'date_issued' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:date_issued',
            'special_instructions' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $prescription = Prescription::create([
                'prescription_number' => Prescription::generateNumber(),
                'patient_name' => $request->patient_name,
                'patient_age' => $request->patient_age,
                'patient_contact' => $request->patient_contact,
                'patient_address' => $request->patient_address,
                'doctor_name' => $request->doctor_name,
                'doctor_license' => $request->doctor_license,
                'date_issued' => $request->date_issued,
                'valid_until' => $request->valid_until,
                'special_instructions' => $request->special_instructions,
                'created_by' => auth()->id(),
                'status' => 'active',
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $product ? $product->name : 'Unknown',
                    'dosage' => $product ? $product->dosage_amount . ' ' . $product->dosage_unit : null,
                    'quantity_prescribed' => $item['quantity'],
                    'quantity_remaining' => $item['quantity'],
                    'quantity_dispensed' => 0,
                    'frequency' => $item['frequency'] ?? null,
                    'duration' => $item['duration'] ?? null,
                    'special_note' => $item['special_note'] ?? null,
                ]);
            }

            DB::commit();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'add_prescription',
                'Prescriptions',
                "Added new prescription #{$prescription->prescription_number} for {$prescription->patient_name} with " . count($request->items) . " item(s)",
                'Success'
            );

            // ✅ AJAX RESPONSE
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'message' => '✅ Prescription created successfully!',
                    'redirect' => route('prescriptions.show', $prescription),
                    'prescription_number' => $prescription->prescription_number,
                    'patient_name' => $prescription->patient_name
                ]);
            }

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Prescription created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => '❌ Failed to create prescription: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to create prescription: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('items.product', 'createdBy');
        return view('prescriptions.show', compact('prescription'));
    }

    public function print(Prescription $prescription)
    {
        $prescription->load('items.product', 'createdBy');
        return view('prescriptions.print', compact('prescription'));
    }

    public function destroy(Prescription $prescription)
    {
        if ($prescription->status === 'used') {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => '❌ Cannot delete a used prescription.'
            ], 400);
        }

        $prescriptionNumber = $prescription->prescription_number;
        $patientName = $prescription->patient_name;
        $prescription->delete();

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete_prescription',
            'Prescriptions',
            "Deleted prescription #{$prescriptionNumber} for {$patientName}",
            'Success'
        );

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => '🗑️ Prescription deleted successfully!',
            'prescription_number' => $prescriptionNumber,
            'patient_name' => $patientName
        ]);
    }

    public function edit(Prescription $prescription)
    {
        if ($prescription->status !== 'active') {
            return back()->with('error', 'Only active prescriptions can be edited.');
        }

        $products = Product::orderBy('name')->get();
        $prescription->load('items');

        return view('prescriptions.edit', compact('prescription', 'products'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        if ($prescription->status !== 'active') {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => '❌ Cannot edit this prescription.'
            ], 400);
        }

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_age' => 'nullable|integer|min:0',
            'patient_contact' => 'nullable|string|max:20',
            'doctor_name' => 'required|string|max:255',
            'doctor_license' => 'nullable|string|max:50',
            'date_issued' => 'required|date',
            'valid_until' => 'nullable|date|after_or_equal:date_issued',
            'special_instructions' => 'nullable|string',
            'status' => 'nullable|in:active,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $oldPatient = $prescription->patient_name;
            $oldStatus = $prescription->status;

            $prescription->update([
                'patient_name' => $request->patient_name,
                'patient_age' => $request->patient_age,
                'patient_contact' => $request->patient_contact,
                'patient_address' => $request->patient_address,
                'doctor_name' => $request->doctor_name,
                'doctor_license' => $request->doctor_license,
                'date_issued' => $request->date_issued,
                'valid_until' => $request->valid_until,
                'special_instructions' => $request->special_instructions,
                'status' => $request->status ?? 'active',
            ]);

            $prescription->items()->delete();

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $product ? $product->name : 'Unknown',
                    'dosage' => $product ? $product->dosage_amount . ' ' . $product->dosage_unit : null,
                    'quantity_prescribed' => $item['quantity'],
                    'quantity_remaining' => $item['quantity'],
                    'quantity_dispensed' => 0,
                    'frequency' => $item['frequency'] ?? null,
                    'duration' => $item['duration'] ?? null,
                    'special_note' => $item['special_note'] ?? null,
                ]);
            }

            DB::commit();

            $statusText = $prescription->status == 'cancelled' ? 'cancelled' : 'updated';
            
            $changes = [];
            if ($oldPatient != $request->patient_name) {
                $changes[] = "patient: {$oldPatient} → {$request->patient_name}";
            }
            if ($oldStatus != $prescription->status) {
                $changes[] = "status: {$oldStatus} → {$prescription->status}";
            }
            $changeList = !empty($changes) ? ' - Changes: ' . implode(', ', $changes) : '';

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_prescription',
                'Prescriptions',
                "{$statusText} prescription #{$prescription->prescription_number}{$changeList}",
                'Success'
            );

            // ✅ AJAX RESPONSE
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'message' => '✅ Prescription updated successfully!',
                    'prescription_number' => $prescription->prescription_number,
                    'patient_name' => $prescription->patient_name,
                    'redirect' => route('prescriptions.index')
                ]);
            }

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Prescription updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'status' => 'error',
                    'message' => '❌ Failed to update prescription: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to update prescription: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $prescriptions = Prescription::with(['items.product'])
            ->where('status', 'active')
            ->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('prescription_number', 'like', "%{$search}%");
            })
            ->where(function ($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->get();

        return response()->json(['success' => true, 'data' => $prescriptions]);
    }

    public function getPrescription($id)
    {
        $prescription = Prescription::with(['items.product'])->findOrFail($id);
        return response()->json(['success' => true, 'data' => $prescription]);
    }

    public function cancel(Request $request, Prescription $prescription)
    {
        if ($prescription->status !== 'active') {
            return back()->with('error', 'Only active prescriptions can be cancelled.');
        }

        $prescriptionNumber = $prescription->prescription_number;
        $patientName = $prescription->patient_name;
        
        $prescription->update(['status' => 'cancelled']);

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'cancel_prescription',
            'Prescriptions',
            "Cancelled prescription #{$prescriptionNumber} for {$patientName}",
            'Success'
        );

        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription cancelled successfully!');
    }
}