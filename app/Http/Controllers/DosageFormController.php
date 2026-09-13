<?php

namespace App\Http\Controllers;

use App\Models\DosageForm;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DosageFormController extends Controller
{
    public function index(Request $request)
    {
        $query = DosageForm::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // ✅ CHANGED FROM 10 TO 30 ITEMS PER PAGE
        $dosageForms = $query->orderBy('name')->paginate(30);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('dosage-forms.partials.table', compact('dosageForms'))->render(),
            ]);
        }

        return view('dosage-forms.index', compact('dosageForms'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:dosage_forms',
                'abbreviation' => 'nullable|string|max:50',
                'description' => 'nullable|string|max:500',
            ]);

            $dosageForm = DosageForm::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'abbreviation' => $request->abbreviation,
                'description' => $request->description,
                'is_active' => true,
            ]);

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username ?? 'System',
                'add_dosage_form',
                'Dosage Forms',
                "Added new dosage form: {$dosageForm->name}" . ($dosageForm->abbreviation ? " ({$dosageForm->abbreviation})" : ''),
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Dosage form created successfully!',
                'data' => $dosageForm,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, DosageForm $dosageForm)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:dosage_forms,name,' . $dosageForm->id,
                'abbreviation' => 'nullable|string|max:50',
                'description' => 'nullable|string|max:500',
            ]);

            $oldName = $dosageForm->name;
            $oldAbbreviation = $dosageForm->abbreviation;
            
            $dosageForm->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'abbreviation' => $request->abbreviation,
                'description' => $request->description,
            ]);

            $changes = [];
            if ($oldName != $request->name) {
                $changes[] = "Name: {$oldName} → {$request->name}";
            }
            if ($oldAbbreviation != $request->abbreviation) {
                $changes[] = "Unit: " . ($oldAbbreviation ?? 'N/A') . " → " . ($request->abbreviation ?? 'N/A');
            }
            $changeLog = !empty($changes) ? ' - ' . implode(', ', $changes) : '';

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username ?? 'System',
                'update_dosage_form',
                'Dosage Forms',
                "Updated dosage form: {$dosageForm->name}{$changeLog}",
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Dosage form updated successfully!',
                'data' => $dosageForm,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $dosageForm = DosageForm::find($id);
            
            if (!$dosageForm) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dosage form not found.',
                ], 404);
            }

            if ($dosageForm->products()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete dosage form because it is used by products.',
                ], 422);
            }

            $name = $dosageForm->name;
            $abbreviation = $dosageForm->abbreviation;
            $dosageForm->delete();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username ?? 'System',
                'delete_dosage_form',
                'Dosage Forms',
                "Deleted dosage form: {$name}" . ($abbreviation ? " ({$abbreviation})" : ''),
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Dosage form deleted successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleStatus(Request $request, DosageForm $dosageForm)
    {
        try {
            $dosageForm->is_active = !$dosageForm->is_active;
            $dosageForm->save();

            $status = $dosageForm->is_active ? 'activated' : 'deactivated';
            
            ActivityLog::log(
                auth()->id(),
                auth()->user()->username ?? 'System',
                'toggle_dosage_form_status',
                'Dosage Forms',
                ucfirst($status) . " dosage form: {$dosageForm->name}",
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Dosage form status updated!',
                'is_active' => $dosageForm->is_active,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDosageForms(Request $request)
    {
        $dosageForms = DosageForm::active()
            ->when($request->search, function ($query, $search) {
                return $query->search($search);
            })
            ->limit(20)
            ->get(['id', 'name', 'abbreviation']);

        return response()->json($dosageForms);
    }
}