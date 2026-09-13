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
        /* ============================================
           🎯 THERMAL PRINTER OPTIMIZED - 58mm/80mm
           ============================================ */

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
            line-height: 1.3;
            background: white;
            color: #000;
        }

        .receipt-container {
            width: 100%;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
        }

        .pharmacy-name {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pharmacy-address,
        .pharmacy-contact,
        .pharmacy-tin {
            font-size: 8px;
            margin-bottom: 1px;
            line-height: 1.2;
        }

        /* ===== RECEIPT INFO ===== */
        .receipt-info {
            margin-bottom: 4px;
            font-size: 8px;
            line-height: 1.4;
        }

        .receipt-info div {
            margin-bottom: 1px;
        }

        .receipt-info .label {
            font-weight: bold;
        }

        /* ===== DIVIDER ===== */
        .divider {
            border-top: 1px dashed #000;
            margin: 3px 0;
        }

        .divider-thick {
            border-top: 2px solid #000;
            margin: 3px 0;
        }

        /* ===== ITEMS TABLE ===== */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 2px 0;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 1.5px 0;
            font-size: 8px;
            line-height: 1.3;
        }

        .items-table .item-name {
            width: 44%;
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

        .promo-badge {
            color: #9c27b0;
            font-size: 7px;
            font-weight: bold;
        }

        /* ===== TOTALS TABLE ===== */
        .totals-table {
            width: 100%;
            margin-top: 4px;
            border-top: 1px dashed #000;
            padding-top: 4px;
        }

        .totals-table tr td {
            padding: 1.5px 0;
            font-size: 8px;
            line-height: 1.3;
        }

        .totals-table tr td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .totals-table .total-row {
            border-top: 2px solid #000;
            font-weight: bold;
            font-size: 10px !important;
        }

        .totals-table .total-row td {
            padding-top: 3px;
            font-size: 10px;
        }

        .totals-table .total-row td:last-child {
            font-size: 10px;
        }

        /* ===== BARCODE SECTION ===== */
        .barcode-section {
            text-align: center;
            margin: 3px 0;
        }

        .barcode-label {
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .product-barcode {
            margin-bottom: 3px;
            padding: 2px 0;
            border-bottom: 1px dotted #ddd;
        }

        .product-barcode:last-child {
            border-bottom: none;
        }

        .product-barcode .barcode-product-name {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .product-barcode .barcode-number {
            font-size: 7px;
            letter-spacing: 1px;
            margin-top: 0;
        }

        svg,
        .barcode-img {
            max-width: 100%;
            height: auto;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            margin-top: 6px;
            padding-top: 4px;
            border-top: 1px dashed #000;
            font-size: 7px;
            line-height: 1.4;
        }

        .thank-you {
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .note {
            font-style: italic;
            font-size: 7px;
            color: #666;
        }

        .cut-line {
            text-align: center;
            margin-top: 6px;
            font-size: 6px;
            color: #999;
            letter-spacing: 2px;
        }

        /* ===== RESPONSIVE ===== */
        @media print {
            body {
                margin: 0;
                padding: 1.5mm 2mm;
                width: 58mm;
            }
            .no-print {
                display: none !important;
            }
        }

        @media (max-width: 58mm) {
            body {
                width: 100%;
                padding: 1mm 1.5mm;
            }
            .pharmacy-name {
                font-size: 11px;
            }
            .pharmacy-address,
            .pharmacy-contact,
            .pharmacy-tin {
                font-size: 7px;
            }
            .items-table th,
            .items-table td {
                font-size: 7px;
            }
            .totals-table tr td {
                font-size: 7px;
            }
            .totals-table .total-row td {
                font-size: 9px;
            }
            .thank-you {
                font-size: 9px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- ===== HEADER ===== -->
        <div class="header">
            <div class="pharmacy-name">{{ $pharmacy['name'] ?? 'ALPHAMED PHARMACY' }}</div>
            @if(isset($pharmacy['address']) && $pharmacy['address'])
                <div class="pharmacy-address">{{ $pharmacy['address'] }}</div>
            @endif
            @if(isset($pharmacy['contact']) && $pharmacy['contact'])
                <div class="pharmacy-contact">Tel: {{ $pharmacy['contact'] }}</div>
            @endif
            @if(isset($pharmacy['tin']) && $pharmacy['tin'])
                <div class="pharmacy-tin">TIN: {{ $pharmacy['tin'] }}</div>
            @endif
        </div>

        <!-- ===== RECEIPT INFO ===== -->
        <div class="receipt-info">
            <div><span class="label">Receipt:</span> {{ $sale->invoice_no }}</div>
            <div><span class="label">Date:</span> {{ $sale->created_at->format('m/d/Y h:i A') }}</div>
            <div><span class="label">Cashier:</span> {{ $sale->user->username ?? 'Staff' }}</div>
            <div>
                <span class="label">Customer:</span>
                @if($sale->customer_type && $sale->customer_type != 'walk_in')
                    {{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }}
                    @if($sale->discount_percent > 0)
                        ({{ $sale->discount_percent }}% off)
                    @endif
                @else
                    Walk-in
                @endif
            </div>
            @if($sale->id_number)
            <div><span class="label">ID #:</span> {{ $sale->id_number }}</div>
            @endif
        </div>

        <div class="divider"></div>

        <!-- ===== ITEMS ===== -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="item-name">Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Price</th>
                    <th class="total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr>
                    <td class="item-name">
                        {{ Str::limit($item->product->name ?? 'Product', 20) }}
                        @if($item->discount_percent > 0)
                            <br><span class="promo-badge">🔥 {{ $item->discount_percent }}% OFF</span>
                        @endif
                        @if($item->sell_type == 'box' && $item->pieces_per_box > 0)
                            <br><span style="font-size: 6px; color: #666;">({{ $item->pieces_per_box }} pcs/box)</span>
                        @endif
                    </td>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="price">₱{{ number_format($item->unit_price, 2) }}</td>
                    <td class="total">₱{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- ===== PRODUCT BARCODES ===== -->
        @php
            $productsWithBarcode = $sale->items->filter(function($item) {
                return $item->product && $item->product->barcode;
            });
        @endphp

        @if($productsWithBarcode->count() > 0)
            <div class="divider"></div>
            <div class="barcode-section">
                <div class="barcode-label">Product Barcodes</div>
                @foreach($productsWithBarcode as $item)
                    <div class="product-barcode">
                        <div class="barcode-product-name">{{ Str::limit($item->product->name, 20) }}</div>
                        @php
                            $generator = new BarcodeGeneratorHTML();
                            $barcodeNumber = $item->product->barcode;
                            $barcodeType = $item->product->barcode_type ?? 'EAN13';
                            $barcodeTypeConst = $barcodeType === 'CODE128' 
                                ? BarcodeGeneratorHTML::TYPE_CODE_128 
                                : BarcodeGeneratorHTML::TYPE_EAN_13;
                            
                            $formattedBarcode = $barcodeNumber;
                            if(strlen($barcodeNumber) == 13 && $barcodeType == 'EAN13') {
                                $formattedBarcode = substr($barcodeNumber, 0, 3) . '-' . 
                                                   substr($barcodeNumber, 3, 6) . '-' . 
                                                   substr($barcodeNumber, 9, 3) . '-' . 
                                                   substr($barcodeNumber, 12, 1);
                            }
                        @endphp
                        <div style="margin: 1px 0; line-height: 0;">
                            {!! $generator->getBarcode($barcodeNumber, $barcodeTypeConst, 1, 18) !!}
                        </div>
                        <div class="barcode-number">{{ $formattedBarcode }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="divider"></div>

        <!-- ===== TOTALS ===== -->
        <table class="totals-table">
            @php
                $totalPromoDiscount = \DB::table('sale_items')
                                       ->where('sale_id', $sale->id)
                                       ->sum('discount_amount');
            @endphp

            <tr>
                <td>Subtotal:</td>
                <td>₱{{ number_format($sale->subtotal, 2) }}</td>
            </tr>

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

        <!-- ===== FOOTER ===== -->
        <div class="footer">
            <div class="thank-you">THANK YOU!</div>
            <div class="note">Valid for 30 days</div>
            <div style="font-size: 6px; color: #999; margin-top: 2px;">
                {{ $sale->created_at->format('Y-m-d H:i:s') }}
            </div>
        </div>

        <div class="cut-line">— — — CUT HERE — — —</div>
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