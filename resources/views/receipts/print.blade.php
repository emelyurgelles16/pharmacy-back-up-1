@php
    use Picqer\Barcode\BarcodeGeneratorHTML;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $sale->invoice_no }}</title>
    <style>
    /* THERMAL PRINTER OPTIMIZED - 58mm/80mm */
    @page {
        size: 58mm auto;
        margin: 0;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Courier New', monospace;
    }
    
    body {
        width: 58mm;
        margin: 0 auto;
        padding: 1.5mm 2mm;
        font-size: 9px;
        line-height: 1.2;
        background: white;
    }
    
    .receipt-container {
        width: 100%;
    }
    
    /* Header */
    .header {
        text-align: center;
        margin-bottom: 4px;
        border-bottom: 1px dashed #000;
        padding-bottom: 3px;
    }
    
    .pharmacy-name {
        font-weight: bold;
        font-size: 11px;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .pharmacy-address, .pharmacy-contact, .pharmacy-tin {
        font-size: 7px;
        margin-bottom: 1px;
    }
    
    /* Receipt Info */
    .receipt-info {
        margin-bottom: 4px;
        font-size: 7px;
    }
    
    .receipt-info div {
        margin-bottom: 1px;
    }
    
    /* Items Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }
    
    .items-table th {
        text-align: left;
        border-bottom: 1px dashed #000;
        padding: 2px 0;
        font-size: 7px;
    }
    
    .items-table td {
        padding: 1px 0;
        font-size: 7px;
    }
    
    .items-table .qty {
        width: 12%;
        text-align: center;
    }
    
    .items-table .price {
        width: 22%;
        text-align: right;
    }
    
    .items-table .total {
        width: 22%;
        text-align: right;
    }
    
    /* Totals Table */
    .totals-table {
        width: 100%;
        margin-top: 4px;
        border-top: 1px dashed #000;
        padding-top: 4px;
    }
    
    .totals-table tr td {
        padding: 1px 0;
        font-size: 7px;
    }
    
    .totals-table tr td:last-child {
        text-align: right;
        font-weight: bold;
    }
    
    .total-row {
        border-top: 2px solid #000;
        font-weight: bold;
        font-size: 9px !important;
    }
    
    /* Footer */
    .footer {
        text-align: center;
        margin-top: 6px;
        padding-top: 4px;
        border-top: 1px dashed #000;
        font-size: 6px;
    }
    
    .thank-you {
        font-weight: bold;
        margin-bottom: 2px;
        font-size: 8px;
    }
    
    .note {
        font-style: italic;
        font-size: 6px;
    }
    
    .divider {
        border-top: 1px dashed #000;
        margin: 2px 0;
    }
    
    .cut-line {
        text-align: center;
        margin-top: 6px;
        font-size: 5px;
        color: #666;
    }
    
    .promo-badge {
        color: #9c27b0;
        font-size: 6px;
    }
    
    .barcode-section {
        text-align: center;
        margin: 3px 0;
    }
    
    .product-barcode {
        margin-bottom: 3px;
        padding: 1px 0;
    }
    
    svg, .barcode-img {
        max-width: 100%;
        height: auto;
    }
</style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="pharmacy-name">{{ $pharmacy['name'] }}</div>
            @if($pharmacy['address'])
                <div class="pharmacy-address">{{ $pharmacy['address'] }}</div>
            @endif
            @if($pharmacy['contact'])
                <div class="pharmacy-contact">Tel: {{ $pharmacy['contact'] }}</div>
            @endif
            @if($pharmacy['tin'])
                <div class="pharmacy-tin">TIN: {{ $pharmacy['tin'] }}</div>
            @endif
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div>Receipt: {{ $sale->invoice_no }}</div>
            <div>Date: {{ $sale->created_at->format('m/d/Y h:i A') }}</div>
            <div>Cashier: {{ $sale->user->username ?? 'Staff' }}</div>
            <div>Customer: 
                @if($sale->customer_type && $sale->customer_type != 'walk_in')
                    {{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }}
                    @if($sale->discount_percent > 0)
                        ({{ $sale->discount_percent }}% off)
                    @endif
                @else
                    Walk-in
                @endif
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Price</th>
                    <th class="total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td>
                        {{ Str::limit($item->product->name ?? 'Product', 20) }}
                        @if($item->discount_percent > 0)
                        <br><span class="promo-badge">PROMO {{ $item->discount_percent }}%</span>
                        @endif
                    </td>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="price">₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="total">₱{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Product Barcodes -->
@php
    $productsWithBarcode = $sale->items->filter(function($item) {
        return $item->product && $item->product->barcode;
    });
@endphp

@if($productsWithBarcode->count() > 0)
<div class="divider"></div>
<div class="barcode-section" style="margin: 0; padding: 0;">
    <div class="barcode-label" style="font-size: 6px; margin-bottom: 0;">PRODUCT BARCODES</div>
    @foreach($productsWithBarcode as $item)
    <div class="product-barcode" style="margin: 0; padding: 0; line-height: 1;">
        <div style="font-size: 7px; font-weight: bold; margin-bottom: 0;">{{ Str::limit($item->product->name, 20) }}</div>
        @php
            $generator = new BarcodeGeneratorHTML();
            $barcodeType = $item->product->barcode_type ?? 'EAN13';
            $barcodeTypeConst = $barcodeType === 'CODE128' ? BarcodeGeneratorHTML::TYPE_CODE_128 : BarcodeGeneratorHTML::TYPE_EAN_13;
            $barcodeNumber = $item->product->barcode;
            if(strlen($barcodeNumber) == 13 && $barcodeType == 'EAN13') {
                $formattedBarcode = substr($barcodeNumber, 0, 3) . '-' . 
                                   substr($barcodeNumber, 3, 6) . '-' . 
                                   substr($barcodeNumber, 9, 3) . '-' . 
                                   substr($barcodeNumber, 12, 1);
            } else {
                $formattedBarcode = $barcodeNumber;
            }
        @endphp
        <div style="margin: 0; line-height: 0;">{!! $generator->getBarcode($barcodeNumber, $barcodeTypeConst, 1, 18) !!}</div>
        <div style="font-size: 6px; letter-spacing: 1px; margin-top: 0;">{{ $formattedBarcode }}</div>
    </div>
    @endforeach
</div>
@endif
        
        <div class="divider"></div>
        
        <!-- Totals -->
        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td>₱{{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            
            @php
                $totalPromoDiscount = \DB::table('sale_items')
                                       ->where('sale_id', $sale->id)
                                       ->sum('discount_amount');
            @endphp
            
            @if($totalPromoDiscount > 0)
            <tr>
                <td>Promo Discounts:</td>
                <td>-₱{{ number_format($totalPromoDiscount, 2) }}</td>
            </tr>
            @endif
            
            @if($sale->discount > 0)
            <tr>
                <td>
                    Discount 
                    @if($sale->customer_type && $sale->customer_type != 'walk_in')
                        ({{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }})
                    @endif
                    :
                </td>
                <td>-₱{{ number_format($sale->discount, 2) }}</td>
            </tr>
            @endif
            
            <tr class="total-row">
                <td>TOTAL:</td>
                <td>₱{{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Cash Tendered:</td>
                <td>₱{{ number_format($sale->cash_tendered, 2) }}</td>
            </tr>
            <tr>
                <td>Change:</td>
                <td>₱{{ number_format($sale->change, 2) }}</td>
            </tr>
        </table>
        
        <!-- Footer -->
        <div class="footer">
            @php
                $receiptBarcodeGenerator = new BarcodeGeneratorHTML();
            @endphp
            
            <div class="thank-you">THANK YOU!</div>
            <div class="note">Valid for 30 days</div>
        </div>
        
        <div class="cut-line">--- CUT HERE ---</div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 500);
        }
    </script>
</body>
</html>