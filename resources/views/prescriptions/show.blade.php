@extends('layouts.app')

@section('title', 'Prescription #' . $prescription->prescription_number)

@section('content')
<style>
    * {
        font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
    }

    .prescription-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 20px;
        animation: pageFadeIn 0.6s ease;
    }

    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .prescription-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-radius: 28px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08), 0 5px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: box-shadow 0.3s ease;
    }

    .prescription-card:hover {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12), 0 5px 25px rgba(0, 0, 0, 0.06);
    }

    .prescription-header {
        background: linear-gradient(135deg, #0d5c2a 0%, #1a7a3a 50%, #2e7d32 100%);
        color: white;
        padding: 35px 40px 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .prescription-header::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }

    .prescription-header::after {
        content: "";
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        pointer-events: none;
    }

    .prescription-header h2 {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 1;
    }

    .prescription-header h2 i {
        margin-right: 10px;
        opacity: 0.8;
    }

    .rx-badge {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        display: inline-block;
        padding: 10px 28px;
        border-radius: 50px;
        font-size: 18px;
        font-weight: 700;
        margin-top: 8px;
        letter-spacing: 1px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .rx-badge:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.02);
    }

    .status-badge {
        position: absolute;
        top: 20px;
        right: 25px;
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.5px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        z-index: 2;
        animation: statusPulse 2s infinite alternate;
    }

    @keyframes statusPulse {
        0% { transform: scale(1); }
        100% { transform: scale(1.03); }
    }

    .status-active {
        background: rgba(76, 175, 80, 0.9);
        color: white;
    }

    .status-expired {
        background: rgba(244, 67, 54, 0.9);
        color: white;
    }

    .status-used {
        background: rgba(158, 158, 158, 0.9);
        color: white;
    }

    .status-cancelled {
        background: rgba(255, 152, 0, 0.9);
        color: white;
    }

    .prescription-header .meta-info {
        display: flex;
        justify-content: center;
        gap: 35px;
        flex-wrap: wrap;
        margin-top: 18px;
        position: relative;
        z-index: 1;
        font-size: 14px;
        opacity: 0.9;
    }

    .prescription-header .meta-info i {
        margin-right: 6px;
        opacity: 0.7;
    }

    .prescription-body {
        padding: 32px 35px 30px;
    }

    /* Info Sections */
    .info-section {
        background: rgba(248, 250, 252, 0.8);
        backdrop-filter: blur(4px);
        border-radius: 18px;
        padding: 20px 24px;
        margin-bottom: 22px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        height: 100%;
    }

    .info-section:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        background: rgba(255, 255, 255, 0.95);
    }

    .info-section h5 {
        color: #0d5c2a;
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-section h5 i {
        color: #1a7a3a;
        font-size: 16px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 20px;
    }

    .info-item {
        display: flex;
        align-items: baseline;
        padding: 4px 0;
    }

    .info-label {
        font-weight: 600;
        color: #7a8a85;
        width: 90px;
        font-size: 13px;
        flex-shrink: 0;
    }

    .info-value {
        color: #1a2a24;
        font-weight: 500;
        font-size: 14px;
    }

    /* Summary Cards */
    .summary-card {
        border-radius: 18px;
        padding: 18px 20px;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        height: 100%;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .summary-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    }

    .summary-card .number {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 2px;
        letter-spacing: -0.02em;
    }

    .summary-card .label {
        font-size: 13px;
        font-weight: 500;
        color: #6a7a74;
        margin-bottom: 0;
    }

    .summary-card .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 20px;
    }

    .summary-green {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    }
    .summary-green .number { color: #2e7d32; }
    .summary-green .icon-circle { background: #4caf50; color: white; }

    .summary-blue {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    }
    .summary-blue .number { color: #1565c0; }
    .summary-blue .icon-circle { background: #1976d2; color: white; }

    .summary-orange {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
    }
    .summary-orange .number { color: #e65100; }
    .summary-orange .icon-circle { background: #ff9800; color: white; }

    /* Progress Bar */
    .progress-wrapper {
        margin-bottom: 22px;
        padding: 4px 0;
    }

    .progress-wrapper .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 500;
        color: #2d3d36;
        margin-bottom: 6px;
    }

    .progress-wrapper .progress-label i {
        color: #1a7a3a;
        margin-right: 6px;
    }

    .progress-wrapper .progress-track {
        height: 8px;
        background: rgba(0, 0, 0, 0.06);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-wrapper .progress-track .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #2e7d32, #4caf50);
        border-radius: 10px;
        transition: width 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        width: 0%;
    }

    /* Medication Table */
    .medication-table {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .medication-table thead th {
        background: linear-gradient(135deg, #0d5c2a 0%, #1a7a3a 100%);
        color: white;
        font-weight: 600;
        font-size: 13px;
        border: none;
        padding: 14px 16px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .medication-table tbody td {
        vertical-align: middle;
        padding: 14px 16px;
        font-size: 14px;
        border-color: rgba(0, 0, 0, 0.04);
    }

    .medication-table tbody tr {
        transition: background 0.2s ease;
    }

    .medication-table tbody tr:hover {
        background: rgba(27, 94, 32, 0.04);
    }

    .medication-table tbody tr:last-child td {
        border-bottom: none;
    }

    .progress-indicator {
        display: inline-block;
        width: 70px;
        height: 5px;
        background: rgba(0, 0, 0, 0.08);
        border-radius: 4px;
        overflow: hidden;
        margin-left: 6px;
        vertical-align: middle;
    }

    .progress-indicator .fill {
        height: 100%;
        background: linear-gradient(90deg, #2e7d32, #4caf50);
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .remaining-low {
        color: #d32f2f;
        font-weight: 700;
        animation: pulseText 1.2s infinite;
    }

    .remaining-medium {
        color: #ef6c00;
        font-weight: 600;
    }

    @keyframes pulseText {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .badge-custom {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .badge-completed {
        background: #4caf50;
        color: white;
    }

    .badge-partial {
        background: #ff9800;
        color: white;
    }

    .badge-pending {
        background: #9e9e9e;
        color: white;
    }

    /* Instructions */
    .instructions-box {
        background: rgba(232, 245, 233, 0.7);
        border-left: 4px solid #1a7a3a;
        padding: 16px 22px;
        border-radius: 14px;
        margin-top: 22px;
        backdrop-filter: blur(4px);
        transition: all 0.3s ease;
    }

    .instructions-box:hover {
        background: rgba(232, 245, 233, 0.9);
    }

    /* Validity Warning */
    .validity-warning {
        padding: 14px 22px;
        border-radius: 14px;
        margin-bottom: 22px;
        backdrop-filter: blur(4px);
        border-left: 4px solid #ff9800;
        background: rgba(255, 243, 224, 0.7);
        transition: all 0.3s ease;
    }

    .validity-warning:hover {
        background: rgba(255, 243, 224, 0.9);
    }

    .validity-expired {
        border-left-color: #f44336;
        background: rgba(255, 235, 238, 0.7);
    }

    .validity-expired:hover {
        background: rgba(255, 235, 238, 0.9);
    }

    /* Footer Actions */
    .footer-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        flex-wrap: wrap;
    }

    .btn-print {
        background: linear-gradient(135deg, #455a64, #607d8b);
        color: white;
        padding: 12px 32px;
        border-radius: 14px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-print:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(69, 90, 100, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-back {
        background: rgba(0, 0, 0, 0.04);
        color: #2d3d36;
        padding: 12px 32px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: rgba(0, 0, 0, 0.08);
        transform: translateY(-3px);
        color: #0d5c2a;
        text-decoration: none;
    }

    .created-by {
        text-align: center;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        font-size: 13px;
        color: #7a8a85;
    }

    .created-by i {
        margin: 0 4px;
        opacity: 0.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .prescription-header {
            padding: 25px 20px 22px;
        }

        .prescription-header h2 {
            font-size: 22px;
        }

        .prescription-body {
            padding: 20px 16px;
        }

        .status-badge {
            position: relative;
            top: auto;
            right: auto;
            display: inline-block;
            margin-bottom: 10px;
        }

        .prescription-header .meta-info {
            gap: 15px;
            font-size: 13px;
            flex-direction: column;
            align-items: center;
        }

        .rx-badge {
            font-size: 15px;
            padding: 8px 20px;
        }

        .summary-card .number {
            font-size: 24px;
        }

        .footer-actions {
            flex-direction: column;
            align-items: center;
        }

        .footer-actions .btn-print,
        .footer-actions .btn-back {
            width: 100%;
            justify-content: center;
        }

        .medication-table thead th {
            font-size: 11px;
            padding: 10px 8px;
        }

        .medication-table tbody td {
            font-size: 12px;
            padding: 10px 8px;
        }
    }

    @media (max-width: 480px) {
        .prescription-header h2 {
            font-size: 18px;
        }

        .prescription-header .meta-info {
            font-size: 12px;
            gap: 8px;
        }

        .info-item {
            flex-direction: column;
            padding: 2px 0;
        }

        .info-label {
            width: auto;
            font-size: 12px;
        }

        .info-value {
            font-size: 13px;
        }
    }

    /* Print Styles */
    @media print {
        .footer-actions, .status-badge, .btn-print, .btn-back {
            display: none !important;
        }

        .prescription-card {
            box-shadow: none !important;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .prescription-header {
            background: #0d5c2a !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .medication-table thead th {
            background: #0d5c2a !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .summary-green, .summary-blue, .summary-orange {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .prescription-body {
            padding: 20px !important;
        }

        .rx-badge {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .info-section {
            break-inside: avoid;
            box-shadow: none !important;
        }

        .summary-card {
            break-inside: avoid;
        }
    }
</style>

<div class="container-fluid prescription-container">
    <div class="prescription-card">
        <!-- Header -->
        <div class="prescription-header">
            @php
                $statusClass = '';
                $statusText = '';
                switch($prescription->status) {
                    case 'active':
                        $statusClass = 'status-active';
                        $statusText = 'Active';
                        break;
                    case 'expired':
                        $statusClass = 'status-expired';
                        $statusText = 'Expired';
                        break;
                    case 'used':
                        $statusClass = 'status-used';
                        $statusText = 'Used';
                        break;
                    case 'cancelled':
                        $statusClass = 'status-cancelled';
                        $statusText = 'Cancelled';
                        break;
                }
            @endphp
            <div class="status-badge {{ $statusClass }}">{{ $statusText }}</div>

            <h2><i class="fas fa-prescription-bottle"></i> Medical Prescription</h2>
            <div class="rx-badge">{{ $prescription->prescription_number }}</div>

            <div class="meta-info">
                <span><i class="fas fa-calendar-alt"></i> Issued: {{ $prescription->date_issued->format('F d, Y') }}</span>
                @if($prescription->valid_until)
                <span><i class="fas fa-hourglass-half"></i> Valid Until: {{ $prescription->valid_until->format('F d, Y') }}</span>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div class="prescription-body">
            <!-- Validity Warning -->
            @php
                $daysLeft = $prescription->valid_until ? now()->diffInDays($prescription->valid_until, false) : null;
                $isExpired = $prescription->valid_until && $prescription->valid_until < now();
            @endphp

            @if($prescription->status == 'active')
                @if($isExpired)
                <div class="validity-warning validity-expired">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>EXPIRED!</strong> This prescription expired on {{ $prescription->valid_until->format('F d, Y') }}.
                </div>
                @elseif($daysLeft !== null && $daysLeft <= 3)
                <div class="validity-warning">
                    <i class="fas fa-clock"></i>
                    <strong>Warning!</strong> This prescription will expire in {{ $daysLeft }} day(s).
                </div>
                @endif
            @endif

            <!-- Patient & Doctor Info -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5><i class="fas fa-user-circle"></i> Patient Information</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Full Name:</span>
                                <span class="info-value">{{ $prescription->patient_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Age:</span>
                                <span class="info-value">{{ $prescription->patient_age ?? 'N/A' }} years old</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Contact:</span>
                                <span class="info-value">{{ $prescription->patient_contact ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address:</span>
                                <span class="info-value">{{ $prescription->patient_address ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-section">
                        <h5><i class="fas fa-stethoscope"></i> Doctor Information</h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Doctor Name:</span>
                                <span class="info-value">{{ $prescription->doctor_name }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">License #:</span>
                                <span class="info-value">{{ $prescription->doctor_license ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medication Summary Cards -->
            @php
                $totalPrescribed = $prescription->items->sum('quantity_prescribed');
                $totalDispensed = $prescription->items->sum('quantity_dispensed');
                $totalRemaining = $prescription->items->sum('quantity_remaining');
                $overallProgress = $totalPrescribed > 0 ? round(($totalDispensed / $totalPrescribed) * 100) : 0;
            @endphp

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="summary-card summary-green">
                        <div class="icon-circle"><i class="fas fa-prescription"></i></div>
                        <div class="number">{{ $totalPrescribed }}</div>
                        <p class="label">Total Prescribed</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card summary-blue">
                        <div class="icon-circle"><i class="fas fa-check-circle"></i></div>
                        <div class="number">{{ $totalDispensed }}</div>
                        <p class="label">Already Dispensed</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card summary-orange">
                        <div class="icon-circle"><i class="fas fa-clock"></i></div>
                        <div class="number">{{ $totalRemaining }}</div>
                        <p class="label">Remaining</p>
                    </div>
                </div>
            </div>

            <!-- Overall Progress Bar -->
            <div class="progress-wrapper">
                <div class="progress-label">
                    <span><i class="fas fa-chart-line"></i> Overall Progress</span>
                    <span class="fw-bold">{{ $overallProgress }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $overallProgress }}%;" id="progressFill"></div>
                </div>
            </div>

            <!-- Medication Table -->
            <h5 class="mb-3"><i class="fas fa-tablets" style="color: #1a7a3a;"></i> Medication List</h5>
            <div class="table-responsive medication-table">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th class="text-center">Prescribed</th>
                            <th class="text-center">Dispensed</th>
                            <th class="text-center">Remaining</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->items as $item)
                        @php
                            $remaining = $item->quantity_remaining ?? $item->quantity_prescribed;
                            $dispensed = $item->quantity_dispensed ?? 0;
                            $itemProgress = $item->quantity_prescribed > 0 ? round(($dispensed / $item->quantity_prescribed) * 100) : 0;
                            $remainingClass = '';
                            if ($remaining <= 0) {
                                $remainingClass = 'remaining-low';
                            } elseif ($remaining <= 3) {
                                $remainingClass = 'remaining-medium';
                            }
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $item->product_name }}</strong>
                                @if($item->special_note)
                                <br><small class="text-muted"><i class="fas fa-comment"></i> {{ $item->special_note }}</small>
                                @endif
                            </td>
                            <td>{{ $item->dosage ?? '-' }}</td>
                            <td class="text-center">{{ $item->quantity_prescribed }}</td>
                            <td class="text-center">
                                {{ $dispensed }}
                                <div class="progress-indicator">
                                    <div class="fill" style="width: {{ $itemProgress }}%;"></div>
                                </div>
                            </td>
                            <td class="text-center {{ $remainingClass }}">{{ $remaining }}</td>
                            <td>{{ $item->frequency ?? '-' }}</td>
                            <td>{{ $item->duration ?? '-' }}</td>
                            <td>
                                @if($remaining <= 0)
                                    <span class="badge-custom badge-completed">✅ Completed</span>
                                @elseif($dispensed > 0)
                                    <span class="badge-custom badge-partial">⏳ Partial</span>
                                @else
                                    <span class="badge-custom badge-pending">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($prescription->special_instructions)
            <div class="instructions-box">
                <i class="fas fa-info-circle" style="color: #1a7a3a;"></i>
                <strong>Special Instructions:</strong>
                <p class="mb-0 mt-1">{{ $prescription->special_instructions }}</p>
            </div>
            @endif

            <!-- Footer Actions -->
            <div class="footer-actions">
                <a href="{{ route('prescriptions.print', $prescription) }}" target="_blank" class="btn-print">
                    <i class="fas fa-print"></i> Print Prescription
                </a>
                <a href="{{ route('prescriptions.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <div class="created-by">
                <i class="fas fa-user-check"></i> Issued by: {{ $prescription->createdBy->username ?? 'N/A' }}
                <i class="fas fa-circle" style="font-size: 4px; vertical-align: middle; margin: 0 6px; opacity: 0.3;"></i>
                <i class="fas fa-clock"></i> Created: {{ $prescription->created_at->format('F d, Y h:i A') }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bar on load
        const progressFill = document.getElementById('progressFill');
        if (progressFill) {
            const width = progressFill.style.width;
            progressFill.style.width = '0%';
            setTimeout(() => {
                progressFill.style.width = width;
            }, 300);
        }

        // Animate summary numbers with counter
        const numbers = document.querySelectorAll('.summary-card .number');
        numbers.forEach(el => {
            const target = parseInt(el.textContent);
            if (target > 0) {
                let current = 0;
                const step = Math.max(1, Math.floor(target / 30));
                const interval = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(interval);
                    }
                    el.textContent = current;
                }, 30);
            }
        });
    });
</script>
@endsection