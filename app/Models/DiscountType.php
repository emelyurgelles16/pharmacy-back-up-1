<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'discount_percent',
        'requires_id',
        'is_active'
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'requires_id' => 'boolean',
        'is_active' => 'boolean'
    ];
}