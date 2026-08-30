<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 🟢 Show Inventory Page
    public function index()
    {
        try {
            $products = Product::all();
        } catch (\Illuminate\Database\QueryException $e) {
            $products = collect([]);
        }

        return view('inventory', compact('products'));
    }

    // 🟢 Store Product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'type' => 'required'
        ]);

        Product::create($validated + $request->only(['brand', 'dosage', 'category', 'quantity', 'expiry_date']));

        return response()->json(['status' => 'success']);
    }

    // 🟢 Update Product - ✅ FIXED
    public function update(Request $request, Product $product)
    {
        // ✅ UPDATE LANG ANG MGA FIELDS NA NASA PRODUCTS TABLE
        $product->update([
            'name' => $request->input('name'),
            'barcode' => $request->input('barcode'),
            'brand' => $request->input('brand'),
            'dosage_amount' => $request->input('dosage_amount'),
            'dosage_unit' => $request->input('dosage_unit'),
            'form' => $request->input('form'),
            'type' => $request->input('type'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'image' => $request->input('image'),
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully!'
        ]);
    }

    // 🟢 Delete Product
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['status' => 'success']);
    }
}