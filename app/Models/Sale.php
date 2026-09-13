<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
    'invoice_no',
    'user_id',
    'subtotal',
    'discount',
    'discount_percent',
    'discount_type_id',
    'customer_type',
    'customer_type_name',
    'id_number',
    'total_amount',
    'cash_tendered',
    'change',
];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ADD RELATIONSHIP FOR DISCOUNT TYPE
    public function discountType()
    {
        return $this->belongsTo(DiscountType::class);
    }
}