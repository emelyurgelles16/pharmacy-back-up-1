@extends('layouts.app')

@php
use App\Models\Setting;
use App\Models\Backup;
@endphp

@section('title', 'System Settings')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - SYSTEM SETTINGS
       ============================================ */

    /* ===== HEADER ===== */
    .settings-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        border-radius: 16px;
        padding: 20px 30px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .settings-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .settings-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        position: relative;
        z-index: 1;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .settings-header h2 i {
        font-size: 24px;
    }

    .settings-header p {
        margin: 4px 0 0 0;
        opacity: 0.85;
        font-size: 14px;
        position: relative;
        z-index: 1;
        padding-left: 44px;
    }

    /* ===== INFO CARDS ===== */
    .info-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid #e9ecef;
    }

    .info-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .card-header-custom {
        background: #f8f9fa;
        padding: 12px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-header-custom h4 {
        margin: 0;
        color: #0b7a33;
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-custom h4 i {
        font-size: 18px;
    }

    .badge-config {
        background: #e8f5e9;
        color: #0b7a33;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }

    .card-body {
        padding: 20px 24px;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        color: white;
        box-shadow: 0 2px 8px rgba(255,152,0,0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255,152,0,0.4);
        color: white;
    }

    .btn-save {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        box-shadow: 0 2px 8px rgba(11,122,51,0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(11,122,51,0.4);
        color: white;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .btn-backup {
        background: linear-gradient(135deg, #0288d1, #01579b);
        color: white;
        box-shadow: 0 2px 8px rgba(2,136,209,0.3);
    }

    .btn-backup:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(2,136,209,0.4);
        color: white;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-group-custom label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    .form-group-custom label i {
        color: #0b7a33;
        width: 18px;
    }

    .form-control-custom {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 14px;
        transition: all 0.3s ease;
        background-color: white;
        width: 100%;
        font-size: 13px;
        height: 38px;
    }

    .form-control-custom:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    textarea.form-control-custom {
        height: auto;
        min-height: 70px;
        resize: vertical;
    }

    .readonly-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 8px 14px;
        color: #333;
        font-size: 13px;
        min-height: 38px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .readonly-text i {
        color: #0b7a33;
        width: 18px;
    }

    .view-mode { display: block; }
    .edit-mode { display: none; }

    /* ===== LOGO PREVIEW ===== */
    .logo-preview {
        margin-top: 8px;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 8px;
        display: inline-block;
    }

    .logo-preview img {
        max-height: 60px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        padding: 4px;
        background: white;
    }

    /* ===== INFO BADGE ===== */
    .info-badge {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 12px 18px;
        margin-top: 18px;
        border-left: 4px solid #0b7a33;
        font-size: 13px;
        color: #0b7a33;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        gap: 8px;
    }

    .info-badge i {
        font-size: 16px;
        margin-top: 1px;
    }

    .info-badge strong {
        font-weight: 600;
    }

    .info-badge small {
        font-size: 12px;
        display: block;
        margin-left: 0;
        width: 100%;
        color: #2e7d32;
        padding-left: 24px;
    }

    /* ===== ACTION BUTTONS ===== */
    .action-buttons {
        display: none;
        gap: 12px;
        margin-top: 18px;
        justify-content: flex-end;
        padding-top: 16px;
        border-top: 1px dashed #e9ecef;
    }

    .action-buttons.show {
        display: flex;
    }

    .backup-actions {
        display: flex;
        gap: 12px;
        margin-top: 18px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    /* ===== FILE INPUT ===== */
    .file-input-wrapper {
        position: relative;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-input-label {
        background: #e9ecef;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-block;
        color: #0b7a33;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #0b7a33;
        color: white;
    }

    /* ===== BACKUP STATUS CARDS ===== */
    .backup-status-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin: 18px 0 8px 0;
    }

    .backup-status-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .backup-status-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }

    .backup-status-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .backup-status-card:first-child .backup-status-icon {
        background: #e8f5e9;
        color: #0b7a33;
    }

    .backup-status-card:last-child .backup-status-icon {
        background: #e3f2fd;
        color: #01579b;
    }

    .backup-status-info {
        flex: 1;
    }

    .backup-status-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 2px;
    }

    .backup-status-value {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
    }

    .backup-status-value .text-muted {
        font-weight: 400;
        font-size: 13px;
    }

    .backup-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 2px;
    }

    .backup-status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .backup-status-badge.info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .backup-status-badge.warning {
        background: #fff3cd;
        color: #856404;
    }

    .backup-status-badge.disabled {
        background: #e9ecef;
        color: #6c757d;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .settings-header {
            padding: 16px 20px;
        }
        .settings-header h2 {
            font-size: 20px;
        }
        .settings-header p {
            padding-left: 0;
            font-size: 13px;
        }
        .backup-status-grid {
            grid-template-columns: 1fr;
        }
        .backup-status-card {
            flex-direction: row;
            text-align: left;
        }
        .card-header-custom {
            flex-direction: column;
            align-items: flex-start;
            padding: 12px 16px;
        }
        .card-header-custom h4 {
            font-size: 14px;
        }
        .card-body {
            padding: 16px;
        }
        .backup-actions {
            flex-direction: column;
        }
        .backup-actions .btn {
            width: 100%;
            justify-content: center;
        }
        .action-buttons {
            flex-direction: column;
        }
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
        .backup-status-value {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .settings-header h2 {
            font-size: 18px;
        }
        .settings-header h2 i {
            font-size: 18px;
        }
        .settings-header p {
            font-size: 12px;
        }
        .card-header-custom h4 {
            font-size: 13px;
        }
        .card-header-custom h4 i {
            font-size: 15px;
        }
        .form-group-custom label {
            font-size: 12px;
        }
        .form-control-custom {
            font-size: 12px;
            height: 34px;
            padding: 6px 12px;
        }
        .readonly-text {
            font-size: 12px;
            min-height: 34px;
            padding: 6px 12px;
        }
        .btn {
            font-size: 12px;
            padding: 6px 16px;
        }
        .info-badge {
            font-size: 12px;
            padding: 10px 14px;
        }
        .info-badge small {
            font-size: 11px;
            padding-left: 0;
        }
        .backup-status-value {
            font-size: 12px;
        }
        .backup-status-label {
            font-size: 10px;
        }
        .badge-config {
            font-size: 10px;
            padding: 2px 10px;
        }
        .file-input-label {
            font-size: 12px;
            padding: 6px 14px;
        }
        .logo-preview img {
            max-height: 45px;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- ===== HEADER ===== -->
    <div class="settings-header">
        <h2>
            <i class="fas fa-sliders-h"></i>
            System Configuration
        </h2>
        <p>Manage pharmacy details and data backup preferences</p>
    </div>

    <!-- ===== SECTION 1: PHARMACY INFORMATION ===== -->
    <div class="info-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-building"></i>
                Pharmacy Information
            </h4>
            <button type="button" id="editPharmacyBtn" class="btn btn-edit">
                <i class="fas fa-edit me-2"></i> Edit Information
            </button>
        </div>

        <div class="card-body">
            <form id="pharmacyForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Pharmacy Name -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-signature"></i> Pharmacy Name <span class="text-danger">*</span></label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-store"></i> {{ $settings['pharmacy_name'] ?? 'AER Pharmacy' }}
                            </div>
                            <input type="text" name="pharmacy_name" class="form-control-custom edit-mode"
                                   value="{{ $settings['pharmacy_name'] ?? '' }}" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-map-marker-alt"></i> Address</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-location-dot"></i> {{ $settings['pharmacy_address'] ?? 'Not set' }}
                            </div>
                            <textarea name="pharmacy_address" class="form-control-custom edit-mode" rows="3">{{ $settings['pharmacy_address'] ?? '' }}</textarea>
                        </div>

                        <!-- Contact Number -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-phone-alt"></i> Contact Number</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-phone"></i> {{ $settings['pharmacy_contact'] ?? 'Not set' }}
                            </div>
                            <input type="text" name="pharmacy_contact" class="form-control-custom edit-mode"
                                   value="{{ $settings['pharmacy_contact'] ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Email -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-envelope"></i> {{ $settings['pharmacy_email'] ?? 'Not set' }}
                            </div>
                            <input type="email" name="pharmacy_email" class="form-control-custom edit-mode"
                                   value="{{ $settings['pharmacy_email'] ?? '' }}">
                        </div>

                        <!-- TIN -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-id-card"></i> TIN Number</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-id-card"></i> {{ $settings['pharmacy_tin'] ?? 'Not set' }}
                            </div>
                            <input type="text" name="pharmacy_tin" class="form-control-custom edit-mode"
                                   value="{{ $settings['pharmacy_tin'] ?? '' }}">
                        </div>

                        <!-- Logo -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-image"></i> Pharmacy Logo</label>
                            <div class="readonly-text view-mode">
                                @if(!empty($settings['pharmacy_logo']))
                                    <div class="logo-preview">
                                        <img src="{{ asset('storage/' . $settings['pharmacy_logo']) }}" alt="Pharmacy Logo">
                                    </div>
                                @else
                                    <i class="fas fa-image"></i> No logo uploaded
                                @endif
                            </div>
                            <div class="edit-mode">
                                <div class="file-input-wrapper">
                                    <label class="file-input-label">
                                        <i class="fas fa-upload"></i> Choose Logo
                                        <input type="file" name="pharmacy_logo" accept="image/jpeg,image/png,image/jpg">
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size: 12px;">Recommended: 200x200px, Max: 2MB (JPG, PNG)</small>
                                @if(!empty($settings['pharmacy_logo']))
                                    <div class="logo-preview mt-2">
                                        <img src="{{ asset('storage/' . $settings['pharmacy_logo']) }}" alt="Current" height="45">
                                        <small class="d-block text-success" style="font-size: 12px;">Current logo</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-badge">
                    <i class="fas fa-lightbulb"></i>
                    <strong>📌 Usage Guide:</strong>
                    <small>• Pharmacy Name & Logo appear on receipts, reports, and system header</small>
                    <small>• Address, Contact, Email, and TIN are used for official documents</small>
                </div>

                <!-- Action Buttons -->
                <div id="pharmacyActions" class="action-buttons">
                    <button type="button" id="cancelPharmacyBtn" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== SECTION 2: BACKUP & RECOVERY ===== -->
    <div class="info-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-database"></i>
                Database Backup
            </h4>
            <span class="badge-config"><i class="fas fa-shield-alt me-1"></i> Data Protection</span>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-custom">
                        <label><i class="fas fa-calendar-alt"></i> Auto Backup Schedule</label>
                        <select class="form-control-custom" id="backup_schedule">
                            @php
                                $backupSchedule = Setting::get('backup_schedule', 'weekly');
                            @endphp
                            <option value="daily" {{ $backupSchedule == 'daily' ? 'selected' : '' }}>📅 Daily</option>
                            <option value="weekly" {{ $backupSchedule == 'weekly' ? 'selected' : '' }}>📆 Weekly (Recommended)</option>
                            <option value="monthly" {{ $backupSchedule == 'monthly' ? 'selected' : '' }}>📆 Monthly</option>
                            <option value="disabled" {{ $backupSchedule == 'disabled' ? 'selected' : '' }}>⛔ Disabled</option>
                        </select>
                        <small class="text-muted" style="font-size: 12px;">How often to automatically backup database</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-custom">
                        <label><i class="fas fa-clock"></i> Backup Retention</label>
                        <input type="number" id="backup_retention" class="form-control-custom"
                               value="{{ Setting::get('backup_retention', '30') }}" min="1" max="365">
                        <small class="text-muted" style="font-size: 12px;">Days to keep old backups before deletion</small>
                    </div>
                </div>
            </div>

            <!-- Backup Status Cards -->
            <div class="backup-status-grid">
                <!-- Last Backup -->
                <div class="backup-status-card">
                    <div class="backup-status-icon">
                        <i class="fas fa-clock-rotate-left"></i>
                    </div>
                    <div class="backup-status-info">
                        <div class="backup-status-label">Last Backup</div>
                        <div class="backup-status-value" id="lastBackupDisplay">
                            @php
                                $lastBackup = Backup::getLastSuccessful();
                            @endphp
                            @if($lastBackup)
                                {{ $lastBackup->completed_at->format('F d, Y') }}
                                <span class="text-muted">• {{ $lastBackup->completed_at->format('h:i A') }}</span>
                            @else
                                No backup yet
                            @endif
                        </div>
                        <div class="backup-status-badge" id="lastBackupBadge">
                            @if($lastBackup)
                                <i class="fas fa-check-circle"></i> Successful
                            @else
                                <i class="fas fa-clock"></i> Pending
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Next Backup -->
                <div class="backup-status-card">
                    <div class="backup-status-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="backup-status-info">
                        <div class="backup-status-label">Next Backup</div>
                        <div class="backup-status-value">
                            @php
                                $schedule = Setting::get('backup_schedule', 'weekly');
                                $nextBackup = null;
                                if ($lastBackup && $schedule !== 'disabled') {
                                    $nextBackup = $lastBackup->completed_at->copy();
                                    switch ($schedule) {
                                        case 'daily': $nextBackup->addDay(); break;
                                        case 'weekly': $nextBackup->addWeek(); break;
                                        case 'monthly': $nextBackup->addMonth(); break;
                                    }
                                }
                            @endphp
                            @if($nextBackup)
                                <span id="nextBackupDate">{{ $nextBackup->format('F d, Y') }}</span>
                                <span class="text-muted">•</span>
                                <span id="nextBackupTime" class="text-muted">{{ $nextBackup->format('h:i A') }}</span>
                            @elseif($schedule === 'disabled')
                                <span id="nextBackupDate">No Backup Scheduled</span>
                            @else
                                <span id="nextBackupDate">No backup yet</span>
                            @endif
                        </div>
                        <div class="backup-status-badge" id="nextBackupBadge">
                            @if($nextBackup)
                                <i class="fas fa-hourglass-half"></i>
                                @switch($schedule)
                                    @case('daily') Daily @break
                                    @case('weekly') Weekly @break
                                    @case('monthly') Monthly @break
                                    @default Scheduled
                                @endswitch
                            @elseif($schedule === 'disabled')
                                <i class="fas fa-ban"></i> Disabled
                            @else
                                <i class="fas fa-clock"></i> Pending
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-badge">
                <i class="fas fa-lightbulb"></i>
                <strong>📌 Data Safety:</strong>
                <small>• Prevents data loss (products, sales, users, inventory)</small>
                <small>• Automatic backups run according to schedule</small>
                <small>• Old backups are automatically deleted based on retention period</small>
            </div>

            <div class="backup-actions">
                <button type="button" id="saveBackupBtn" class="btn btn-save">
                    <i class="fas fa-save me-2"></i> Save Backup Settings
                </button>
                <button type="button" id="backupNowBtn" class="btn btn-backup">
                    <i class="fas fa-database me-2"></i> Create Backup Now
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let isEditMode = false;

    // ============================================
    // TOGGLE EDIT MODE
    // ============================================
    $('#editPharmacyBtn').on('click', function() {
        if (!isEditMode) {
            isEditMode = true;
            $('.view-mode').hide();
            $('.edit-mode').show();
            $('#pharmacyActions').addClass('show');
            $(this).html('<i class="fas fa-times me-2"></i> Cancel Edit');
            $(this).removeClass('btn-edit').addClass('btn-cancel');
        } else {
            isEditMode = false;
            $('.view-mode').show();
            $('.edit-mode').hide();
            $('#pharmacyActions').removeClass('show');
            $(this).html('<i class="fas fa-edit me-2"></i> Edit Information');
            $(this).removeClass('btn-cancel').addClass('btn-edit');
        }
    });

    // ============================================
    // CANCEL EDIT
    // ============================================
    $('#cancelPharmacyBtn').on('click', function() {
        isEditMode = false;
        $('.view-mode').show();
        $('.edit-mode').hide();
        $('#pharmacyActions').removeClass('show');
        $('#editPharmacyBtn').html('<i class="fas fa-edit me-2"></i> Edit Information');
        $('#editPharmacyBtn').removeClass('btn-cancel').addClass('btn-edit');
    });

    // ============================================
    // PHARMACY FORM SUBMIT
    // ============================================
    $('#pharmacyForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save your information.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Pharmacy information updated!',
                    confirmButtonColor: '#0b7a33'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong!';
                if (xhr.responseJSON?.message) errorMsg = xhr.responseJSON.message;
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // ============================================
    // FILE INPUT PREVIEW
    // ============================================
    $('input[type="file"]').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.edit-mode .logo-preview img').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // ============================================
    // SAVE BACKUP SETTINGS
    // ============================================
    $('#saveBackupBtn').on('click', function() {
        var schedule = $('#backup_schedule').val();
        var retention = $('#backup_retention').val();

        Swal.fire({
            title: 'Save Backup Settings?',
            html: 'Schedule: <strong>' + schedule + '</strong><br>Retention: <strong>' + retention + ' days</strong>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0b7a33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Save Settings',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route("backup.settings") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        schedule: schedule,
                        retention: retention
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Saved!',
                                text: response.message,
                                confirmButtonColor: '#0b7a33'
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to save settings.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });

    // ============================================
    // CREATE BACKUP NOW
    // ============================================
    $('#backupNowBtn').on('click', function() {
        Swal.fire({
            title: 'Create Backup Now?',
            text: 'This will create a new database backup of the AERPharmacy system.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0288d1',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Create Backup',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Creating Backup...',
                    text: 'Please wait while we create your backup.',
                    allowOutsideClick: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route("backup.create") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: 'manual'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Backup Created!',
                                text: response.message,
                                confirmButtonColor: '#0b7a33'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Backup Failed!',
                                text: response.message,
                                confirmButtonColor: '#d33'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to create backup.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection 