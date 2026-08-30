<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Services\BarcodeService;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeController extends Controller
{
    protected $barcodeService;
    
    public function __construct(BarcodeService $barcodeService)
    {
        $this->barcodeService = $barcodeService;
    }
    
    /**
     * Generate new barcode number (EAN-13 by default)
     */
    public function generate(Request $request)
    {
        $type = $request->get('type', 'EAN13');
        
        if ($type === 'UPCA') {
            $barcode = Product::generateUPCA();
        } else {
            $barcode = Product::generateEAN13();
        }
        
        return response()->json([
            'barcode' => $barcode,
            'type' => $type,
            'length' => strlen($barcode)
        ]);
    }
    
    /**
     * Display barcode image - auto-detect type
     */
    public function image($barcode)
    {
        try {
            // Auto-detect barcode type
            $type = Product::validateBarcode($barcode);
            
            if (!$type) {
                // Default to EAN13 if invalid format
                $type = 'EAN13';
            }
            
            $image = $this->barcodeService->generatePNG($barcode, $type);
            $imageData = base64_decode(str_replace('data:image/png;base64,', '', $image));
            
            return response($imageData)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            // Fallback to SVG
            $type = Product::validateBarcode($barcode) ?? 'EAN13';
            $svg = $this->barcodeService->generateSVG($barcode, $type);
            return response($svg)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }
    }
    
    /**
     * Show print labels form
     */
    public function printLabelsForm()
    {
        $products = Product::whereNotNull('barcode')->get();
        return view('barcodes.print-labels', compact('products'));
    }
    
    /**
     * Generate PDF for barcode labels
     */
    public function printLabels(Request $request)
    {
        $productIds = $request->product_ids;
        $quantities = $request->quantities ?? [];
        
        $products = Product::whereIn('id', $productIds)->get();
        $labelItems = [];
        
        foreach ($products as $product) {
            $qty = $quantities[$product->id] ?? 1;
            for ($i = 0; $i < $qty; $i++) {
                $labelItems[] = $product;
            }
        }
        
        $html = $this->barcodeService->generateLabelSheet($labelItems);
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('barcode-labels.pdf');
    }
    
    /**
     * Print receipt with barcode
     */
    public function printReceiptWithBarcode($saleId)
    {
        $sale = Sale::with('items.product', 'user')->findOrFail($saleId);
        $barcodeService = $this->barcodeService;
        
        $html = view('receipts.print-with-barcode', compact('sale', 'barcodeService'))->render();
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper([0, 0, 226.77, 500], 'portrait');
        
        return $pdf->download('receipt-' . $sale->invoice_no . '.pdf');
    }
}