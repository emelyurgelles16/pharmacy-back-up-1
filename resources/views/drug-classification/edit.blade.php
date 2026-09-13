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
            'type' => $this->determineType($request),
            'description' => $request->description,
            'color' => '#6c757d',
            'icon' => null,
            'requires_prescription' => $request->has('requires_prescription'),
            'requires_special_handling' => $request->has('requires_special_handling'),
            'requires_logging' => $request->has('requires_logging'),
            'is_active' => $request->has('is_active'),
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
            'requires_prescription' => $request->has('requires_prescription'),
            'requires_special_handling' => $request->has('requires_special_handling'),
            'requires_logging' => $request->has('requires_logging'),
            'is_active' => $request->has('is_active'),
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

        return redirect()->route('drug-classification.index')
            ->with('success', 'Drug classification deleted successfully!');
    }
}