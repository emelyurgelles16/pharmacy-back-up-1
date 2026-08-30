<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - {{ $dateFrom }} to {{ $dateTo }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            padding: 5mm;
            background: white;
        }
        
        .report-container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        
        .pharmacy-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        
        .pharmacy-address, .pharmacy-contact {
            font-size: 7px;
        }
        
        .report-title {
            font-size: 12px;
            font-weight: bold;
            margin: 6px 0;
        }
        
        .report-date {
            font-size: 7px;
            margin-bottom: 3px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
            margin-bottom: 12px;
        }
        
        .summary-card {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }
        
        .summary-label {
            font-size: 6px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .summary-value {
            font-size: 11px;
            font-weight: bold;
        }
        
        .section-title {
            font-weight: bold;
            margin: 8px 0 4px 0;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            font-size: 9px;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        
        .items-table th {
            border-bottom: 1px solid #000;
            padding: 3px 2px;
            text-align: left;
            font-size: 7px;
            background: #f5f5f5;
        }
        
        .items-table td {
            border-bottom: 1px solid #ddd;
            padding: 2px;
            font-size: 7px;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .footer {
            text-align: center;
            margin-top: 12px;
            padding-top: 6px;
            border-top: 1px solid #ddd;
            font-size: 6px;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="header">
            <div class="pharmacy-name">{{ $pharmacy['name'] }}</div>
            @if($pharmacy['address'])
            <div class="pharmacy-address">{{ $pharmacy['address'] }}</div>
            @endif
            @if($pharmacy['contact'])
            <div class="pharmacy-contact">Tel: {{ $pharmacy['contact'] }}</div>
            @endif
            <div class="report-title">SALES REPORT</div>
            <div class="report-date">
                Period: {{ \Carbon\Carbon::parse($dateFrom)->format('F d, Y') }} 
                to {{ \Carbon\Carbon::parse($dateTo)->format('F d, Y') }}
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Sales</div>
                <div class="summary-value">₱{{ number_format($totalSales, 2) }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Transactions</div>
                <div class="summary-value">{{ number_format($totalTransactions) }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Items Sold</div>
                <div class="summary-value">{{ number_format($totalItemsSold ?? 0) }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Average Sale</div>
                <div class="summary-value">₱{{ number_format($averageSale ?? 0, 2) }}</div>
            </div>
        </div>

        <!-- Top Selling Products -->
        @if(isset($topProducts) && $topProducts->count() > 0)
        <div class="section-title">TOP SELLING PRODUCTS</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th class="text-right">Qty Sold</th>
                    <th class="text-right">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">{{ number_format($product->total_sold) }} pcs</td>
                    <td class="text-right">₱{{ number_format($product->total_revenue ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Sales Transactions -->
        <div class="section-title">SALES TRANSACTIONS</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Date</th>
                    <th>Cashier</th>
                    <th>Customer</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Discount</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->created_at->format('m/d/Y h:i A') }}</td>
                    <td>{{ $sale->user->username ?? 'N/A' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $sale->customer_type ?? 'Walk-in')) }}</td>
                    <td class="text-right">₱{{ number_format($sale->subtotal, 2) }}</td>
                    <td class="text-right">₱{{ number_format($sale->discount, 2) }}</td>
                    <td class="text-right">₱{{ number_format($sale->total_amount, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No sales found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div>Generated on {{ now()->format('F d, Y h:i A') }}</div>
            <div>© {{ date('Y') }} Pharmacy Management System</div>
        </div>
    </div>

    <script>
    // Auto-print when page loads
    window.onload = function() {
        window.print();
    };
    
    // After print dialog is closed (whether printed or cancelled), close the tab
    window.onafterprint = function() {
        window.close();
    };
</script>
</body>
</html>