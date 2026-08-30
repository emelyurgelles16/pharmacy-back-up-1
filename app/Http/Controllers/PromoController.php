<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promo;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('product')->latest()->get();
        $products = Product::all();
        return view('promos.index', compact('promos', 'products'));
    }
    
    public function create()
    {
        $products = Product::all();
        return view('promos.create', compact('products'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'discount_percent' => 'required|integer|min:1|max:90',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:255'
        ]);
        
        $reason = $request->reason_custom ?: $request->reason;
        
        $product = Product::find($request->product_id);
        $productName = $product ? $product->name : 'Unknown';
        
        Promo::where('product_id', $request->product_id)
             ->where('is_active', true)
             ->update(['is_active' => false]);
        
        $promo = Promo::create([
            'product_id' => $request->product_id,
            'discount_percent' => $request->discount_percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $reason,
            'is_active' => $request->has('is_active')
        ]);

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'add_promo',
            'Promos',
            'Added new promo for: ' . $productName . ' - ' . $request->discount_percent . '% discount' . ($reason ? ' (' . $reason . ')' : ''),
            'Success'
        );
        
        return redirect()->route('promos.index')
                         ->with('success', 'Promo added successfully!');
    }
    
    public function edit(Promo $promo)
    {
        $products = Product::all();
        return view('promos.edit', compact('promo', 'products'));
    }
    
    public function update(Request $request, Promo $promo)
    {
        try {
            \Log::info('Update Request Data:', $request->all());
            
            $request->validate([
                'discount_percent' => 'required|integer|min:1|max:90',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'nullable|string|max:255',
                'is_active' => 'sometimes|boolean'
            ]);
            
            \Log::info('Validation passed');
            
            $oldDiscount = $promo->discount_percent;
            $oldActive = $promo->is_active;
            $productName = $promo->product ? $promo->product->name : 'Unknown';
            
            if ($request->has('is_active') && $request->is_active) {
                Promo::where('product_id', $promo->product_id)
                     ->where('id', '!=', $promo->id)
                     ->where('is_active', true)
                     ->update(['is_active' => false]);
            }
            
            $promo->update([
                'discount_percent' => $request->discount_percent,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'is_active' => $request->has('is_active') ? $request->is_active : $promo->is_active
            ]);

            $changes = [];
            if ($oldDiscount != $request->discount_percent) {
                $changes[] = "discount: {$oldDiscount}% → {$request->discount_percent}%";
            }
            if ($oldActive != $request->is_active) {
                $changes[] = "status: " . ($oldActive ? 'active' : 'inactive') . " → " . ($request->is_active ? 'active' : 'inactive');
            }
            $changeList = !empty($changes) ? ' - Changes: ' . implode(', ', $changes) : '';

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_promo',
                'Promos',
                'Updated promo for: ' . $productName . $changeList,
                'Success'
            );
            
            return response()->json([
                'status' => 'success',
                'message' => 'Promo updated successfully!',
                'promo' => $promo
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating promo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $promo = Promo::with('product')->find($id);
            
            if (!$promo) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Promo not found or already deleted'
                    ], 404);
                }
                
                return redirect()->route('promos.index')
                                ->with('error', 'Promo not found or already deleted');
            }
            
            $productName = $promo->product->name ?? 'Unknown';
            $discount = $promo->discount_percent;
            $promo->delete();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'delete_promo',
                'Promos',
                'Deleted promo for: ' . $productName . ' - ' . $discount . '% discount',
                'Success'
            );
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Promo for '{$productName}' deleted successfully!",
                    'deleted_id' => $id
                ]);
            }
            
            return redirect()->route('promos.index')
                            ->with('success', "Promo for '{$productName}' deleted successfully!");
            
        } catch (\Exception $e) {
            \Log::error('Delete promo error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error deleting promo: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('promos.index')
                            ->with('error', 'Error deleting promo: ' . $e->getMessage());
        }
    }
}