<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockQueue;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\ActivityLog;

class AutoTransferQueueStock extends Command
{
    protected $signature = 'stock:auto-transfer';
    protected $description = 'Auto transfer queued stock when inventory runs out';

    public function handle()
    {
        $transferred = 0;
        
        $queuedStocks = StockQueue::with('product')->get();
        
        foreach ($queuedStocks as $stock) {
            $product = $stock->product;
            
            if (!$product) continue;
            
            $totalPiecesLeft = $product->batches()->where('pieces_left', '>', 0)->sum('pieces_left');
            
            if ($totalPiecesLeft <= 0) {
                $totalPieces = $stock->quantity * $stock->pieces_per_box;
                
                ProductBatch::create([
                    'product_id' => $product->id,
                    'quantity' => $stock->quantity,
                    'pieces_per_box' => $stock->pieces_per_box,
                    'pieces_left' => $totalPieces,
                    'total_pieces' => $totalPieces,
                    'expiry_date' => $stock->expiry_date,
                    'arrival_date' => $stock->arrival_date,
                    'batch_number' => 'CRON-' . time(),
                ]);
                
                $stock->delete();
                $transferred++;
                
                $this->info("Auto-transferred: {$product->name} - {$stock->quantity} boxes");
            }
        }
        
        $this->info("Auto-transferred {$transferred} items from queue to inventory");
    }
}