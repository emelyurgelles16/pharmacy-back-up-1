<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes; // ✅ I-COMMENT ITO
use Illuminate\Support\Str;

class DrugClassification extends Model
{
    // use SoftDeletes; // ✅ I-COMMENT ITO

   protected $fillable = [
    'name',
    'slug',
    'icon',
    'description',
    'color',
    'requires_prescription',
    'requires_special_handling',
    'requires_logging',
    'is_active',
    'display_order'
];

    protected $casts = [
        'requires_prescription' => 'boolean',
        'requires_special_handling' => 'boolean',
        'requires_logging' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getTypeAttribute()
{
    if ($this->requires_prescription && $this->requires_special_handling) {
        return 'Dangerous';
    } elseif ($this->requires_prescription) {
        return 'Prescription';
    } elseif ($this->requires_special_handling || $this->requires_logging) {
        return 'Controlled';
    }
    return 'OTC';
}

    public function products()
    {
        return $this->hasMany(Product::class, 'drug_classification_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}