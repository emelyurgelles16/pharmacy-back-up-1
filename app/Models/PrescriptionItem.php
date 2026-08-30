<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'product_id',
        'product_name',
        'dosage',
        'quantity_prescribed',  // ✅ BAGO
        'quantity_remaining',    // ✅ BAGO
        'quantity_dispensed',
        'frequency',
        'duration',
        'special_note',
    ];

    // Relationships
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
