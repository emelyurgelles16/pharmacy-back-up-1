<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report - Print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #fff;
            padding: 20px;
            font-size: 12px;
        }

        .print-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px double #1b5e20;
            margin-bottom: 20px;
        }

        .print-header h1 {
            font-size: 24px;
            color: #1b5e20;
            margin-bottom: 5px;
        }

        .print-header p {
            color: #555;
            font-size: 13px;
        }

        .print-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #f5f5f5;
            border-radius: 6px;
            font-size: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .print-meta span {
            color: #333;
        }

        .print-meta strong {
            color: #1b5e20;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table thead th {
            background: #1b5e20;
            color: #fff;
            padding: 8px 6px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #1b5e20;
        }

        table tbody td {
            padding: 6px;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tbody tr:hover {
            background: #e8f5e9;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: #999;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-available {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-lowstock {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-expired {
            background: #ffebee;
            color: #c62828;
        }

        .badge-outofstock {
            background: #f5f5f5;
            color: #666;
        }

        .badge-nearexpired {
            background: #fff8e1;
            color: #f57f17;
        }

        .summary-box {
            display: flex;
            gap: 20px;
            margin: 15px 0 20px;
            padding: 15px 20px;
            background: #e8f5e9;
            border-radius: 8px;
            border: 1px solid #a5d6a7;
            flex-wrap: wrap;
        }

        .summary-box .stat {
            flex: 1;
            text-align: center;
            min-width: 100px;
        }

        .summary-box .stat .number {
            font-size: 20px;
            font-weight: 700;
            color: #1b5e20;
        }

        .summary-box .stat .label {
            font-size: 11px;
            color: #555;
            margin-top: 2px;
        }

        .print-footer {
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 11px;
        }

        @media print {
            body {
                padding: 10px;
                font-size: 10px;
            }

            .no-print {
                display: none !important;
            }

            table thead th {
                background: #1b5e20 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .summary-box {
                background: #e8f5e9 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-header {
                border-bottom-color: #1b5e20 !important;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            .summary-box {
                flex-direction: column;
                gap: 10px;
            }

            .summary-box .stat {
                text-align: left;
                padding: 5px 0;
                border-bottom: 1px solid #c8e6c9;
            }

            .summary-box .stat:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>

    <!-- Print / Back Buttons -->
    <div class="no-print" style="text-align: right; margin-bottom: 10px;">
        <button onclick="window.print()" style="padding: 8px 20px; background: #1b5e20; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px;">
            🖨️ Print / Download PDF
        </button>
        <button onclick="window.history.back()" style="padding: 8px 20px; background: #6c757d; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; margin-left: 5px;">
            ⬅️ Back
        </button>
    </div>

    <!-- Header -->
    <div class="print-header">
        <h1>📋 Inventory Report</h1>
        <p>Complete list of all products with stock information</p>
    </div>

    <!-- Meta Info -->
    <div class="print-meta">
        <span><strong>Report Date:</strong> {{ now()->format('F d, Y h:i A') }}</span>
        <span><strong>Total Products:</strong> {{ $totalMedicines }}</span>
        <span><strong>Total Stock (Pieces):</strong> {{ number_format($totalStock) }}</span>
        <span><strong>Generated By:</strong> {{ auth()->user()->username ?? 'System' }}</span>
    </div>

    <!-- Summary Statistics -->
    @php
        $availableCount = 0;
        $lowStockCount = 0;
        $outOfStockCount = 0;
        $nearExpiredCount = 0;
        $expiredCount = 0;

        foreach ($products as $product) {
            foreach ($product->batches as $batch) {
                if ($batch->pieces_left <= 0) {
                    $outOfStockCount++;
                } elseif ($batch->pieces_left <= 100) {
                    $lowStockCount++;
                }
                if ($batch->expiry_date && $batch->expiry_date < now()->addDays(30) && $batch->pieces_left > 0) {
                    $nearExpiredCount++;
                }
                if ($batch->expiry_date && $batch->expiry_date < now() && $batch->pieces_left > 0) {
                    $expiredCount++;
                }
                if ($batch->pieces_left > 0 && (!$batch->expiry_date || $batch->expiry_date > now())) {
                    $availableCount++;
                }
            }
        }
    @endphp

    <div class="summary-box">
        <div class="stat">
            <div class="number">{{ number_format($availableCount) }}</div>
            <div class="label">✅ Available</div>
        </div>
        <div class="stat">
            <div class="number">{{ number_format($lowStockCount) }}</div>
            <div class="label">🟠 Low Stock</div>
        </div>
        <div class="stat">
            <div class="number">{{ number_format($outOfStockCount) }}</div>
            <div class="label">🔴 Out of Stock</div>
        </div>
        <div class="stat">
            <div class="number">{{ number_format($nearExpiredCount) }}</div>
            <div class="label">🟡 Near Expiry</div>
        </div>
        <div class="stat">
            <div class="number">{{ number_format($expiredCount) }}</div>
            <div class="label">⛔ Expired</div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Product Name</th>
                    <th>Barcode</th>
                    <th>Brand</th>
                    <th>Dosage</th>
                    <th>Form</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Batch</th>
                    <th>Total Pcs</th>
                    <th>Pcs Left</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    @foreach($product->batches as $batchIndex => $batch)
                    @php
                        $statusClass = $batch->status;
                        $statusText = $batch->status_text;
                    @endphp
                    <tr>
                        <td>{{ $loop->parent->iteration }}.{{ $batchIndex + 1 }}</td>
                        <td class="text-left"><strong>{{ $product->name }}</strong></td>
                        <td>
                            @if($product->barcode)
                                <span style="font-family: monospace; font-size: 10px;">{{ $product->barcode }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $product->brand ?? '-' }}</td>
                        <td>{{ $product->dosage_amount }} {{ $product->dosage_unit }}</td>
                        <td>{{ $product->form ?? '-' }}</td>
                        <td>{{ $product->category ?? '-' }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>Batch {{ $batchIndex + 1 }}</td>
                        <td>{{ number_format($batch->total_pieces) }}</td>
                        <td>
                            <strong>{{ number_format($batch->pieces_left) }}</strong>
                            @if($batch->pieces_left <= 0)
                                <span style="color: #c62828;">(Empty)</span>
                            @elseif($batch->pieces_left <= 30)
                                <span style="color: #e65100;">(Low)</span>
                            @endif
                        </td>
                        <td>
                            @if($batch->expiry_date)
                                {{ \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') }}
                                @if(\Carbon\Carbon::parse($batch->expiry_date)->isPast())
                                    <span style="color: #c62828;">⚠️</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="13" style="text-align: center; padding: 40px; color: #999;">
                            📭 No products found in inventory.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="print-footer">
        <p>© {{ date('Y') }} Pharmacy System - Inventory Report</p>
        <p>Printed on: {{ now()->format('F d, Y h:i:s A') }}</p>
        <p style="font-size: 9px; color: #ccc;">This is a system-generated report. All rights reserved.</p>
    </div>

    <!-- ✅ AUTO-PRINT AT AUTO-CLOSE -->
    <script>
        // Auto-print when page loads (with delay para ma-load ang styles)
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };

        // After print dialog is closed (whether printed or cancelled), close the tab
        window.onafterprint = function() {
            window.close();
        };
    </script>

</body>
</html>