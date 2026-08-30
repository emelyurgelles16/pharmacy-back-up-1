<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DosageForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ✅ Auto-generate slug when creating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dosageForm) {
            if (empty($dosageForm->slug)) {
                $dosageForm->slug = Str::slug($dosageForm->name);
            }
        });

        static::updating(function ($dosageForm) {
            if ($dosageForm->isDirty('name')) {
                $dosageForm->slug = Str::slug($dosageForm->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('abbreviation', 'like', "%{$search}%");
    }
}