<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Prescription #{{ $prescription->prescription_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: white;
            padding: 20px;
        }
        
        .print-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        
        .prescription-card {
            background: white;
            padding: 30px;
        }
        
        .prescription-header {
            text-align: center;
            border-bottom: 2px dashed #1b5e20;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .prescription-header h2 {
            color: #1b5e20;
            margin-bottom: 10px;
        }
        
        .rx-number {
            font-size: 18px;
            font-weight: bold;
            color: #666;
            margin-top: 5px;
        }
        
        .dates {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .col-md-6 {
            width: 50%;
            padding: 0 10px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-section h5 {
            color: #1b5e20;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .info-item {
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .info-label {
            font-weight: bold;
            width: 80px;
            display: inline-block;
        }
        
        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }
        
        .medication-table th,
        .medication-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        
        .medication-table th {
            background: #1b5e20;
            color: white;
        }
        
        .instructions-box {
            background: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #1b5e20;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .prescription-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-container">
        <div class="prescription-card">
            <div class="prescription-header">
                <h2>Medical Prescription</h2>
                <div class="rx-number">RX #: {{ $prescription->prescription_number }}</div>
                <div class="dates">
                    Date Issued: {{ $prescription->date_issued->format('F d, Y') }}
                    @if($prescription->valid_until)
                    | Valid Until: {{ $prescription->valid_until->format('F d, Y') }}
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5>Patient Information</h5>
                        <div class="info-item"><span class="info-label">Name:</span> {{ $prescription->patient_name }}</div>
                        <div class="info-item"><span class="info-label">Age:</span> {{ $prescription->patient_age ?? 'N/A' }}</div>
                        <div class="info-item"><span class="info-label">Contact:</span> {{ $prescription->patient_contact ?? 'N/A' }}</div>
                        <div class="info-item"><span class="info-label">Address:</span> {{ $prescription->patient_address ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-section">
                        <h5>Doctor Information</h5>
                        <div class="info-item"><span class="info-label">Name:</span> {{ $prescription->doctor_name }}</div>
                        <div class="info-item"><span class="info-label">License:</span> {{ $prescription->doctor_license ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="info-section">
                <h5>Medication List</h5>
                <table class="medication-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Quantity</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->dosage ?? '-' }}</td>
                            <td>{{ $item->quantity_prescribed ?? $item->quantity }}</td>
                            <td>{{ $item->frequency ?? '-' }}</td>
                            <td>{{ $item->duration ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($prescription->special_instructions)
            <div class="instructions-box">
                <strong>Special Instructions:</strong>
                <p style="margin-top: 5px;">{{ $prescription->special_instructions }}</p>
            </div>
            @endif
            
            <div class="footer">
                <p>This prescription is valid for {{ $prescription->valid_until ? $prescription->valid_until->diffInDays($prescription->date_issued) : '30' }} days.</p>
                <p>Issued by: {{ $prescription->createdBy->username ?? 'System' }}</p>
            </div>
        </div>
    </div>
</body>
</html>