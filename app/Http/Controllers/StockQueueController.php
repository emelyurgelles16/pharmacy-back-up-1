<?php

namespace App\Http\Controllers;

use App\Models\StockQueue;
use App\Models\Product;
use App\Models\ProductBatch; // ✅ CORRECT: ProductBatch, NOT ProductBatchBatch
use Illuminate\Http\Request;

class StockQueueController extends Controller
{
    public function index()
    {
        $queuedStocks = StockQueue::where('status', 'in_queue')
            ->with('product', 'addedByUser')
            ->orderBy('arrival_date', 'asc')
            ->get();

        return view('stock-queue.index', compact('queuedStocks'));
    }

    public function transfer($id)
    {
        $queuedStock = StockQueue::findOrFail($id);
        
        // DEBUG: Check what data we have
        \Log::info('Transferring stock queue:', [
            'id' => $queuedStock->id,
            'product_id' => $queuedStock->product_id,
            'product_name' => $queuedStock->product_name,
            'brand' => $queuedStock->brand,
        ]);
        
        // CASE 1: May existing product_id
        if ($queuedStock->product_id) {
            $product = Product::find($queuedStock->product_id);
            
            if (!$product) {
                // Product not found - create new one using queue data
                $product = $this->createProductFromQueue($queuedStock);
            }
        }
        // CASE 2: Walang product_id pero may product_name
        elseif ($queuedStock->product_name && $queuedStock->brand) {
            // Try to find existing product by name and brand
            $product = Product::where('name', $queuedStock->product_name)
                ->where('brand', $queuedStock->brand)
                ->first();
                
            if (!$product) {
                // Create new product
                $product = $this->createProductFromQueue($queuedStock);
            }
        }
        // CASE 3: Completely new product (no product_id, no product_name)
        else {
            return redirect()->back()
                ->with('error', 'Cannot transfer: Missing product information');
        }
        
        // ✅ CREATE ProductBatch (NOT Batch)
        $batch = ProductBatch::create([ // ✅ CHANGE: Batch:: to ProductBatch::
            'product_id' => $product->id,
            'quantity' => $queuedStock->quantity,
            'pieces_per_box' => $queuedStock->pieces_per_box,
            'pieces_left' => $queuedStock->quantity * $queuedStock->pieces_per_box,
            'total_pieces' => $queuedStock->quantity * $queuedStock->pieces_per_box,
            'expiry_date' => $queuedStock->expiry_date,
            'arrival_date' => $queuedStock->arrival_date,
            'batch_number' => 'BATCH-' . time() . '-' . rand(100, 999), // ✅ ADD batch_number
        ]);
        
        \Log::info('Created ProductBatch:', [
            'batch_id' => $batch->id,
            'product_id' => $product->id,
            'pieces' => $batch->total_pieces,
        ]);
        
        // Update queue status
        $queuedStock->update([
            'status' => 'transferred',
            'transferred_at' => now(),
            'transferred_by' => auth()->id(),
        ]);

        return redirect()->back()
            ->with('success', 'Stock transferred successfully! New batch created.');
    }
    
    /**
     * Helper function to create product from queue data
     */
    private function createProductFromQueue($queuedStock)
    {
        return Product::create([
            'name' => $queuedStock->product_name,
            'brand' => $queuedStock->brand,
            'dosage_amount' => $queuedStock->dosage_amount,
            'dosage_unit' => $queuedStock->dosage_unit,
            'form' => $queuedStock->form,
            'type' => $queuedStock->type,
            'category' => $queuedStock->category,
            'price' => $queuedStock->price ?? 0,
        ]);
    }

    public function destroy($id)
    {
        $queuedStock = StockQueue::findOrFail($id);
        $queuedStock->delete();

        return redirect()->back()->with('success', 'Queued stock removed!');
    }
}