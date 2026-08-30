<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockQueue extends Model
{
    use HasFactory;

    protected $table = 'stock_queues';

    // app/Models/StockQueue.php
protected $fillable = [
    'product_id',
    'product_name',
    'barcode', // ✅ ADD THIS
    'brand',
    'dosage_amount',
    'dosage_unit',
    'form',
    'type',
    'category',
    'price',
    'quantity',
    'pieces_per_box',
    'total_pieces',
    'expiry_date',
    'arrival_date',
    'added_by',
    'status',
    'transferred_at',
    'transferred_by',
];

    protected $dates = ['arrival_date', 'expiry_date', 'transferred_at'];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function addedByUser()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function transferredByUser()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }

    // Auto-calculate total pieces
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->quantity && $model->pieces_per_box) {
                $model->total_pieces = $model->quantity * $model->pieces_per_box;
            }
        });
    }
    
    // Accessor for backward compatibility
    public function getDosageAttribute()
    {
        if ($this->dosage_amount && $this->dosage_unit) {
            return $this->dosage_amount . ' ' . $this->dosage_unit;
        }
        return $this->dosage_amount;
    }
}