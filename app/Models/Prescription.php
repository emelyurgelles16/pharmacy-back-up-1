<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_number',
        'patient_name',
        'patient_age',
        'patient_contact',
        'patient_address',
        'doctor_name',
        'doctor_license',
        'date_issued',
        'valid_until',
        'special_instructions',
        'status',
        'created_by',
        'sale_id',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'valid_until' => 'date',
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public static function generateNumber()
{
    $year = date('Y');
    
    // Kunin ang pinakahuling prescription number ngayong taon
    $lastPrescription = self::whereYear('created_at', $year)
        ->orderBy('id', 'desc')
        ->first();
    
    if ($lastPrescription) {
        // Kunin ang last number from existing record
        $lastNumber = (int) substr($lastPrescription->prescription_number, -4);
        $newNumber = $lastNumber + 1;
    } else {
        // Wala pang prescription ngayong taon
        $newNumber = 1;
    }
    
    $number = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    return "RX-{$year}-{$number}";
}
protected static function booted()
{
    static::retrieved(function ($prescription) {
        // Auto-update status kung expired na
        if ($prescription->status === 'active' && 
            $prescription->valid_until && 
            $prescription->valid_until < now()) {
            $prescription->update(['status' => 'expired']);
        }
    });
}
}