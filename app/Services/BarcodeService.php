<?php

namespace App\Services;

use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorHTML;
use App\Models\Product;

class BarcodeService
{
    protected $pngGenerator;
    protected $htmlGenerator;
    
    public function __construct()
    {
        $this->pngGenerator = new BarcodeGeneratorPNG();
        $this->htmlGenerator = new BarcodeGeneratorHTML();
    }
    
    /**
     * Generate barcode as PNG - auto-detect type
     */
    public function generatePNG($barcode, $type = null, $width = 2, $height = 50)
    {
        // Auto-detect type if not specified
        if (!$type) {
            $length = strlen($barcode);
            if ($length === 12) {
                $type = 'UPCA';
            } else {
                $type = 'EAN13';
            }
        }
        
        $barcodeType = $this->getGeneratorType($type);
        $imageData = $this->pngGenerator->getBarcode($barcode, $barcodeType, $width, $height);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
    
    /**
     * Generate barcode as SVG - auto-detect type
     */
    public function generateSVG($barcode, $type = null)
    {
        if (!$type) {
            $length = strlen($barcode);
            if ($length === 12) {
                $type = 'UPCA';
            } else {
                $type = 'EAN13';
            }
        }
        
        $barcodeType = $this->getGeneratorType($type);
        $html = $this->htmlGenerator->getBarcode($barcode, $barcodeType);
        
        // Extract SVG from HTML
        preg_match('/<svg[^>]*>.*<\/svg>/s', $html, $matches);
        return $matches[0] ?? $html;
    }
    
    /**
     * Generate barcode as HTML - auto-detect type
     */
    public function generateHTML($barcode, $type = null)
    {
        if (!$type) {
            $length = strlen($barcode);
            if ($length === 12) {
                $type = 'UPCA';
            } else {
                $type = 'EAN13';
            }
        }
        
        $barcodeType = $this->getGeneratorType($type);
        return $this->htmlGenerator->getBarcode($barcode, $barcodeType);
    }
    
    /**
     * Get generator type
     */
    protected function getGeneratorType($type)
    {
        switch ($type) {
            case 'UPCA':
                return BarcodeGeneratorPNG::TYPE_UPC_A;  // 12 digits
            case 'CODE128':
                return BarcodeGeneratorPNG::TYPE_CODE_128;
            case 'CODE39':
                return BarcodeGeneratorPNG::TYPE_CODE_39;
            case 'EAN13':
            default:
                return BarcodeGeneratorPNG::TYPE_EAN_13;  // 13 digits
        }
    }
    
    /**
     * Print barcode labels (multiple products)
     */
    public function generateLabelSheet($products)
    {
        $html = '<html><head>
        <style>
            @page { size: A4; margin: 0.5cm; }
            .label {
                display: inline-block;
                width: 180px;
                padding: 10px;
                margin: 5px;
                border: 1px dashed #ccc;
                text-align: center;
                font-family: Arial, sans-serif;
            }
            .barcode { margin: 10px 0; }
            .product-name { font-size: 12px; font-weight: bold; }
            .product-price { font-size: 11px; color: #555; }
            .barcode-number { font-size: 10px; font-family: monospace; }
        </style>
        </head><body>';
        
        foreach ($products as $product) {
            $barcodeHtml = $this->generateHTML($product->barcode);
            $html .= '
            <div class="label">
                <div class="product-name">' . e($product->name) . '</div>
                <div class="barcode">' . $barcodeHtml . '</div>
                <div class="barcode-number">' . $product->barcode . '</div>
                <div class="product-price">₱' . number_format($product->price, 2) . '</div>
            </div>';
        }
        
        $html .= '</body></html>';
        return $html;
    }
}