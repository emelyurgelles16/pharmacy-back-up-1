<?php

namespace App\Http\Controllers\DrugClassification;

use App\Http\Controllers\Controller;
use App\Models\DrugClassification;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Cache;

class DrugClassificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view drug classifications']);
    }

    public function index()
    {
        $classifications = DrugClassification::orderBy('display_order')
            ->orderBy('name')
            ->paginate(15);
        
        $stats = [
            'total' => DrugClassification::count(),
            'active' => DrugClassification::where('is_active', true)->count(),
        ];

        return view('drug-classification.index', compact('classifications', 'stats'));
    }

    public function create()
    {
        return view('drug-classification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:drug_classifications',
            'description' => 'nullable|string',
            'requires_prescription' => 'nullable|boolean',
            'requires_special_handling' => 'nullable|boolean',
            'requires_logging' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $classification = DrugClassification::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'color' => '#6c757d',
            'icon' => null,
            'requires_prescription' => $request->input('requires_prescription', 0),
            'requires_special_handling' => $request->input('requires_special_handling', 0),
            'requires_logging' => $request->input('requires_logging', 0),
            'is_active' => $request->input('is_active', 0),
            'display_order' => 0,
        ]);

        Cache::forget('drug_classifications');

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'add_drug_classification',
            'Drug Classification',
            'Added drug classification: ' . $request->name,
            'Success'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Drug classification created successfully!',
                'data' => $classification
            ]);
        }

        return redirect()->route('drug-classification.index')
            ->with('success', 'Drug classification created successfully!');
    }

    public function show(DrugClassification $drugClassification)
    {
        $products = $drugClassification->products()->paginate(10);
        return view('drug-classification.show', compact('drugClassification', 'products'));
    }

    public function edit(DrugClassification $drugClassification)
    {
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'classification' => $drugClassification
            ]);
        }

        return view('drug-classification.edit', compact('drugClassification'));
    }

    public function update(Request $request, DrugClassification $drugClassification)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:drug_classifications,name,' . $drugClassification->id,
            'description' => 'nullable|string',
            'requires_prescription' => 'nullable|boolean',
            'requires_special_handling' => 'nullable|boolean',
            'requires_logging' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $oldName = $drugClassification->name;

        $drugClassification->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'description' => $request->description,
            'requires_prescription' => $request->input('requires_prescription', 0),
            'requires_special_handling' => $request->input('requires_special_handling', 0),
            'requires_logging' => $request->input('requires_logging', 0),
            'is_active' => $request->input('is_active', 0),
        ]);

        Cache::forget('drug_classifications');

        $changes = [];
        if ($oldName != $request->name) $changes[] = "Name: $oldName → {$request->name}";
        $changeLog = !empty($changes) ? ' - Changes: ' . implode(', ', $changes) : '';

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_drug_classification',
            'Drug Classification',
            'Updated drug classification: ' . $request->name . $changeLog,
            'Success'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Drug classification updated successfully!',
                'data' => $drugClassification
            ]);
        }

        return redirect()->route('drug-classification.index')
            ->with('success', 'Drug classification updated successfully!');
    }

    public function destroy(DrugClassification $drugClassification)
    {
        $name = $drugClassification->name;

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete_drug_classification',
            'Drug Classification',
            'Deleted drug classification: ' . $name,
            'Success'
        );

        $drugClassification->delete();
        Cache::forget('drug_classifications');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Drug classification deleted successfully!'
            ]);
        }

        return redirect()->route('drug-classification.index')
            ->with('success', 'Drug classification deleted successfully!');
    }
}