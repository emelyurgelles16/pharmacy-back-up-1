<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockQueue;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Check if pieces_left reached 0 or below
        if ($product->pieces_left <= 0 || $product->quantity <= 0) {
            $this->checkAndTransferFromQueue($product);
        }
    }

    /**
     * Check for queued stock and transfer to inventory
     */
    private function checkAndTransferFromQueue(Product $product): void
    {
        // Find oldest queued stock for this product
        $queuedStock = StockQueue::where(function($query) use ($product) {
                $query->where('product_id', $product->id)
                      ->orWhere(function($q) use ($product) {
                          $q->where('product_name', $product->name)
                            ->where('brand', $product->brand);
                      });
            })
            ->where('status', 'in_queue')
            ->orderBy('arrival_date', 'asc')
            ->first();

        if (!$queuedStock) {
            return; // No queued stock found
        }

        // Transfer queued stock to inventory
        $product->quantity = $queuedStock->quantity;
        $product->pieces_per_box = $queuedStock->pieces_per_box;
        $product->total_pieces = $queuedStock->total_pieces;
        $product->pieces_left = $queuedStock->total_pieces;
        
        // Update price and expiry if provided in queue
        if ($queuedStock->price) {
            $product->price = $queuedStock->price;
        }
        if ($queuedStock->expiry_date) {
            $product->expiry_date = $queuedStock->expiry_date;
        }
        
        $product->save();

        // Update queue status
        $queuedStock->update([
            'status' => 'transferred',
            'transferred_at' => now(),
            'transferred_by' => auth()->check() ? auth()->user()->username : 'system',
        ]);

        // Optional: Log the transfer
        Log::info('Stock auto-transferred from queue', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'queue_id' => $queuedStock->id,
            'quantity' => $queuedStock->quantity,
        ]);
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        // Optional: You can add logic here if needed
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        // Optional: Clean up related queue entries
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}