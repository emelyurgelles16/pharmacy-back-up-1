<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'barcode',
        'barcode_type',
        'brand',
        'dosage_amount',
        'dosage_unit',
        'form',
        'dosage_form_id',
        'type',
        'category',
        'drug_classification_id',
        'price',
        'image',
        // ✅ ADD THESE MISSING COLUMNS
        'batch_id',
        'batch_number',
        'pieces_left',
        'stock_source',
        'last_stock_queue_id',
    ];

    // ✅ PROTEKTAHAN ANG STOCK COLUMNS
    protected $guarded = [
        'quantity',
        'pieces_per_box',
        'total_pieces',
        'pieces_left',
        'expiry_date',
    ];

    // ============ BARCODE METHODS ============
    
    public static function generateBarcode()
    {
        return self::generateEAN13();
    }

    public static function generateEAN13()
    {
        $prefix = '890';
        $random = str_pad(mt_rand(1, 999999999), 9, '0', STR_PAD_LEFT);
        $barcode = $prefix . $random;
        $checksum = self::calculateEANChecksum($barcode);
        return $barcode . $checksum;
    }

    public static function generateUPCA()
    {
        $random = str_pad(mt_rand(1, 99999999999), 11, '0', STR_PAD_LEFT);
        $checksum = self::calculateUPCChecksum($random);
        return $random . $checksum;
    }

    private static function calculateEANChecksum($barcode)
    {
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int)$barcode[$i];
            $sum += ($i % 2 === 0) ? $digit * 1 : $digit * 3;
        }
        return (10 - ($sum % 10)) % 10;
    }

    private static function calculateUPCChecksum($barcode)
    {
        $sum = 0;
        for ($i = 0; $i < 11; $i++) {
            $digit = (int)$barcode[$i];
            $sum += ($i % 2 === 0) ? $digit * 3 : $digit * 1;
        }
        return (10 - ($sum % 10)) % 10;
    }

    public static function validateBarcode($barcode)
    {
        $length = strlen($barcode);
        
        if ($length === 13 && preg_match('/^\d{13}$/', $barcode)) {
            return 'EAN13';
        }
        
        if ($length === 12 && preg_match('/^\d{12}$/', $barcode)) {
            return 'UPCA';
        }
        
        return false;
    }

    public function getBarcodeTypeAttribute()
    {
        if (!$this->barcode) return null;
        
        $length = strlen($this->barcode);
        if ($length === 13) return 'EAN-13';
        if ($length === 12) return 'UPC-A';
        return 'Unknown';
    }

    // ============ BARCODE IMAGE ============
    
    public function getBarcodeImageAttribute()
    {
        if (!$this->barcode) {
            return null;
        }

        $generator = new BarcodeGeneratorPNG();
        
        $type = BarcodeGeneratorPNG::TYPE_EAN_13;
        if (strlen($this->barcode) === 12) {
            $type = BarcodeGeneratorPNG::TYPE_UPC_A;
        }
        
        $barcodeData = $generator->getBarcode($this->barcode, $type, 2, 50);
        return 'data:image/png;base64,' . base64_encode($barcodeData);
    }

    // ============ RELATIONSHIPS ============

    public function batches()
    {
        return $this->hasMany(ProductBatch::class, 'product_id');
    }

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function dosageForm()
    {
        return $this->belongsTo(DosageForm::class);
    }

    public function drugClassification()
    {
        return $this->belongsTo(DrugClassification::class, 'drug_classification_id');
    }

    public function activePromo()
    {
        return $this->hasOne(Promo::class)
                    ->where('is_active', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
    }

    // ============ STOCK METHODS ============

    public function getTotalQuantityAttribute()
    {
        return $this->batches()->sum('quantity');
    }

    public function getTotalPiecesAttribute()
    {
        $total = 0;
        foreach ($this->batches as $batch) {
            $total += $batch->quantity * $batch->pieces_per_box;
        }
        return $total;
    }

    public function getTotalPiecesLeftAttribute()
    {
        return $this->batches()
            ->where('pieces_left', '>', 0)
            ->where(function($q) {
                $q->where('expiry_date', '>', now())
                  ->orWhereNull('expiry_date');
            })
            ->sum('pieces_left');
    }

    public function getEarliestExpiryDateAttribute()
    {
        $earliest = $this->batches()
            ->whereNotNull('expiry_date')
            ->orderBy('expiry_date', 'asc')
            ->first();
        
        return $earliest ? $earliest->expiry_date : null;
    }

    public function getDosageDisplayAttribute()
    {
        if ($this->dosage_amount && $this->dosage_unit) {
            return $this->dosage_amount . ' ' . $this->dosage_unit;
        }
        return $this->dosage_old ?? '';
    }

    public function getStatusAttribute()
    {
        $hasExpired = false;
        $hasNearExpired = false;
        $hasLowStock = false;
        
        foreach ($this->batches as $batch) {
            $batchStatus = $batch->status;
            
            if ($batchStatus === 'expired') {
                $hasExpired = true;
            } elseif ($batchStatus === 'nearexpired') {
                $hasNearExpired = true;
            } elseif ($batchStatus === 'lowstock') {
                $hasLowStock = true;
            }
        }
        
        if ($hasExpired) return 'expired';
        if ($hasNearExpired && $hasLowStock) return 'nearexpired-lowstock';
        if ($hasNearExpired) return 'nearexpired';
        if ($hasLowStock) return 'lowstock';
        
        return 'available';
    }

    public function getHasActivePromoAttribute()
    {
        return !is_null($this->activePromo);
    }

    public function getCurrentDiscountPercentAttribute()
    {
        return $this->hasActivePromo ? $this->activePromo->discount_percent : 0;
    }

    public function getDiscountedPriceAttribute()
    {
        $discount = ($this->price * $this->currentDiscountPercent) / 100;
        return $this->price - $discount;
    }
}