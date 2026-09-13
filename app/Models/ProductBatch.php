<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductBatch extends Model
{
    use HasFactory;

    protected $table = 'product_batches';

    protected $fillable = [
        'product_id',
        'quantity',
        'pieces_per_box',
        'pieces_left',
        'total_pieces',
        'expiry_date',
        'arrival_date',
        'batch_number'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'arrival_date' => 'date',
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Get total pieces (calculated)
    public function getTotalPiecesAttribute()
    {
        return $this->quantity * $this->pieces_per_box;
    }

    // ✅ FIXED: Status calculation
    public function getStatusAttribute()
    {
        $today = Carbon::now();
        
        // Check if expired
        if ($this->expiry_date && $today->greaterThan($this->expiry_date)) {
            return 'expired';
        }
        
        // Calculate days to expiry
        $daysToExpiry = 9999;
        if ($this->expiry_date) {
            $daysToExpiry = $today->diffInDays($this->expiry_date, false);
        }
        
        // Calculate LOW STOCK (30% rule)
        $totalPieces = $this->total_pieces;
        $piecesLeft = $this->pieces_left;
        
        $isLowStock = false;
        if ($totalPieces > 0) {
            $stockPercentage = ($piecesLeft / $totalPieces) * 100;
            $isLowStock = $piecesLeft <= 30;
        }
        
        // Check near expiry (≤30 days)
        $isNearExpired = ($daysToExpiry <= 30 && $daysToExpiry > 0);
        
        if ($isNearExpired && $isLowStock) {
            return 'nearexpired-lowstock';
        }
        if ($isNearExpired) {
            return 'nearexpired';
        }
        if ($isLowStock) {
            return 'lowstock';
        }
        
        return 'available';
    }

    // Get status text
    public function getStatusTextAttribute()
    {
        $texts = [
            'available' => 'Available',
            'lowstock' => 'Low Stock',
            'nearexpired' => 'Near Expired',
            'expired' => 'Expired',
            'nearexpired-lowstock' => 'Near Expired + Low Stock'
        ];
        
        return $texts[$this->status] ?? 'Available';
    }
    
    // Helper method to get stock percentage
    public function getStockPercentageAttribute()
    {
        if ($this->total_pieces <= 0) {
            return 0;
        }
        return ($this->pieces_left / $this->total_pieces) * 100;
    }
}