<?php

namespace App\Http\Controllers;

use App\Models\DiscountType;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DiscountTypeController extends Controller
{
    public function index()
    {
        $discountTypes = DiscountType::all();
        return view('discount-types.index', compact('discountTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:10|unique:discount_types',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        $discountType = DiscountType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'discount_percent' => $request->discount_percent,
            'requires_id' => $request->has('requires_id'),
            'is_active' => true,
        ]);

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'add_discount_type',
            'Discount Types',
            'Added new discount type: ' . $request->name . ' (' . $request->discount_percent . '%) - Code: ' . strtoupper($request->code),
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Discount type created successfully!'
        ]);
    }

    public function update(Request $request, DiscountType $discountType)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:10|unique:discount_types,code,' . $discountType->id,
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        $oldName = $discountType->name;
        $oldPercent = $discountType->discount_percent;
        $oldCode = $discountType->code;
        $oldActive = $discountType->is_active;

        $discountType->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'discount_percent' => $request->discount_percent,
            'requires_id' => $request->has('requires_id'),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $changes = [];
        if ($oldName != $request->name) $changes[] = "name: {$oldName} → {$request->name}";
        if ($oldPercent != $request->discount_percent) $changes[] = "discount: {$oldPercent}% → {$request->discount_percent}%";
        if ($oldCode != strtoupper($request->code)) $changes[] = "code: {$oldCode} → " . strtoupper($request->code);
        if ($oldActive != $request->has('is_active')) $changes[] = "status: " . ($oldActive ? 'active' : 'inactive') . " → " . ($request->has('is_active') ? 'active' : 'inactive');
        $changeList = !empty($changes) ? ' - Changes: ' . implode(', ', $changes) : '';

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_discount_type',
            'Discount Types',
            'Updated discount type: ' . $oldName . $changeList,
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Discount type updated successfully!'
        ]);
    }

    public function destroy(DiscountType $discountType)
    {
        $name = $discountType->name;
        $code = $discountType->code;
        $percent = $discountType->discount_percent;
        
        $discountType->delete();

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete_discount_type',
            'Discount Types',
            'Deleted discount type: ' . $name . ' (' . $percent . '%) - Code: ' . $code,
            'Success'
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Discount type deleted successfully!'
        ]);
    }
}