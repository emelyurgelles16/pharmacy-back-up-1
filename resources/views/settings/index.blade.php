@extends('layouts.app')

@php
use App\Models\Setting;
use App\Models\Backup;
@endphp

@section('title', 'System Settings')

@section('content')
<style>
    .settings-header {
        background: linear-gradient(135deg, #1b5e20 0%, #0b7a33 100%);
        border-radius: 20px;
        padding: 30px 35px;
        margin-bottom: 35px;
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .settings-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    
    .settings-header p {
        margin: 10px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    
    .info-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 35px;
        transition: all 0.3s ease;
        border: 1px solid #eef2f6;
    }
    
    .info-card:hover {
        box-shadow: 0 12px 40px rgba(0,0,0,0.1);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        padding: 20px 28px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h4 {
        margin: 0;
        color: #1b5e20;
        font-weight: 700;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .card-header-custom h4 i {
        font-size: 26px;
        background: linear-gradient(135deg, #1b5e20, #0b7a33);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .badge-config {
        background: #e8f5e9;
        color: #1b5e20;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #ff9800, #f57c00);
        border: none;
        padding: 10px 28px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255,152,0,0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255,152,0,0.4);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #1b5e20, #0b7a33);
        border: none;
        padding: 12px 32px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(27,94,32,0.3);
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,94,32,0.4);
    }
    
    .btn-cancel {
        background: #6c757d;
        border: none;
        padding: 12px 28px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .btn-backup {
        background: linear-gradient(135deg, #0288d1, #01579b);
        border: none;
        padding: 12px 28px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(2,136,209,0.3);
    }
    
    .btn-backup:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(2,136,209,0.4);
    }
    
    .form-group-custom {
        margin-bottom: 22px;
    }
    
    .form-group-custom label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }
    
    .form-group-custom label i {
        color: #1b5e20;
        width: 20px;
    }
    
    .readonly-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        color: #333;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    
    .readonly-text i {
        color: #1b5e20;
        margin-right: 10px;
        width: 20px;
    }
    
    .form-control-custom {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        background-color: white;
        width: 100%;
    }
    
    .form-control-custom:focus {
        border-color: #1b5e20;
        box-shadow: 0 0 0 4px rgba(27, 94, 32, 0.1);
        outline: none;
    }
    
    .edit-mode {
        display: none;
    }
    
    .logo-preview {
        margin-top: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 12px;
        display: inline-block;
    }
    
    .logo-preview img {
        max-height: 70px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 4px;
        background: white;
    }
    
    .info-badge {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-radius: 16px;
        padding: 18px 24px;
        margin-top: 25px;
        border-left: 5px solid #1b5e20;
    }
    
    .action-buttons {
        display: none;
        gap: 15px;
        margin-top: 25px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 2px dashed #e9ecef;
    }
    
    .action-buttons.show {
        display: flex;
    }
    
    .backup-actions {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        justify-content: flex-end;
    }
    
    .file-input-wrapper {
        position: relative;
    }
    
    .file-input-wrapper input[type="file"] {
        display: none;
    }
    
    .file-input-label {
        background: #e9ecef;
        padding: 10px 18px;
        border-radius: 10px;
        cursor: pointer;
        display: inline-block;
        color: #1b5e20;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .file-input-label:hover {
        background: #1b5e20;
        color: white;
    }
    
    /* ===== BACKUP STATUS CARDS ===== */
    .backup-status-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 25px 0 10px 0;
    }

    .backup-status-card {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .backup-status-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .backup-status-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .backup-status-card:first-child .backup-status-icon {
        background: #e8f5e9;
        color: #1b5e20;
    }

    .backup-status-card:last-child .backup-status-icon {
        background: #e3f2fd;
        color: #01579b;
    }

    .backup-status-info {
        flex: 1;
    }

    .backup-status-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 2px;
    }

    .backup-status-value {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
    }

    .backup-status-value .text-muted {
        font-weight: 400;
        font-size: 14px;
    }

    .backup-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
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
    
    hr {
        margin: 25px 0;
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e9ecef, transparent);
    }
    
    @media (max-width: 768px) {
        .backup-status-grid {
            grid-template-columns: 1fr;
        }
        .backup-status-card {
            flex-direction: column;
            text-align: center;
        }
        .settings-header {
            padding: 20px;
        }
        .settings-header h2 {
            font-size: 22px;
        }
        .card-header-custom {
            flex-direction: column;
            align-items: flex-start;
        }
        .backup-actions {
            flex-direction: column;
        }
        .backup-actions button {
            width: 100%;
            justify-content: center;
        }
        .action-buttons {
            flex-direction: column;
        }
        .action-buttons button {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="settings-header">
        <h2>
            <i class="fas fa-sliders-h me-3"></i> System Configuration
        </h2>
        <p>Manage pharmacy details and data backup preferences</p>
    </div>

    <!-- ========== SECTION 1: PHARMACY INFORMATION ========== -->
    <div class="info-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-building"></i> 
                Pharmacy Information
            </h4>
            <button type="button" id="editPharmacyBtn" class="btn-edit">
                <i class="fas fa-edit me-2"></i> Edit Information
            </button>
        </div>
        
        <div class="card-body p-4">
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
                                <small class="text-muted d-block mt-2">Recommended: 200x200px, Max: 2MB (JPG, PNG)</small>
                                @if(!empty($settings['pharmacy_logo']))
                                    <div class="logo-preview mt-2">
                                        <img src="{{ asset('storage/' . $settings['pharmacy_logo']) }}" alt="Current" height="45">
                                        <small class="d-block text-success">Current logo</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-badge">
                    <i class="fas fa-lightbulb"></i>
                    <strong>📌 Usage Guide:</strong><br>
                    <small>• Pharmacy Name & Logo appear on receipts, reports, and system header</small><br>
                    <small>• Address, Contact, Email, and TIN are used for official documents</small>
                </div>
                
                <!-- Action Buttons -->
                <div id="pharmacyActions" class="action-buttons">
                    <button type="button" id="cancelPharmacyBtn" class="btn-cancel">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== SECTION 2: BACKUP & RECOVERY ========== -->
    <div class="info-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-database"></i> 
                Database Backup
            </h4>
            <span class="badge-config"><i class="fas fa-shield-alt me-1"></i> Data Protection</span>
        </div>
        
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-custom">
                        <label><i class="fas fa-calendar-alt"></i> Auto Backup Schedule</label>
                        <select class="form-control-custom" id="backup_schedule" onchange="updateNextBackup()">
                            @php
                                $backupSchedule = Setting::get('backup_schedule', 'weekly');
                            @endphp
                            <option value="daily" {{ $backupSchedule == 'daily' ? 'selected' : '' }}>📅 Daily</option>
                            <option value="weekly" {{ $backupSchedule == 'weekly' ? 'selected' : '' }}>📆 Weekly (Recommended)</option>
                            <option value="monthly" {{ $backupSchedule == 'monthly' ? 'selected' : '' }}>📆 Monthly</option>
                            <option value="disabled" {{ $backupSchedule == 'disabled' ? 'selected' : '' }}>⛔ Disabled</option>
                        </select>
                        <small class="text-muted">How often to automatically backup database</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group-custom">
                        <label><i class="fas fa-clock"></i> Backup Retention</label>
                        <input type="number" id="backup_retention" class="form-control-custom" 
                               value="{{ Setting::get('backup_retention', '30') }}" min="1" max="365">
                        <small class="text-muted">Days to keep old backups before deletion</small>
                    </div>
                </div>
            </div>

            <!-- ===== BACKUP STATUS CARDS ===== -->
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
                <strong>📌 Data Safety:</strong><br>
                <small>• Prevents data loss (products, sales, users, inventory)</small><br>
                <small>• Automatic backups run according to schedule</small><br>
                <small>• Old backups are automatically deleted based on retention period</small>
            </div>
            
            <div class="backup-actions">
                <button type="button" id="saveBackupBtn" class="btn-save">
                    <i class="fas fa-save me-2"></i> Save Backup Settings
                </button>
                <button type="button" id="backupNowBtn" class="btn-backup">
                    <i class="fas fa-database me-2"></i> Create Backup Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let isEditMode = false;
    
    // Toggle Edit Mode for Pharmacy Section
    $('#editPharmacyBtn').on('click', function() {
        if (!isEditMode) {
            isEditMode = true;
            $('.view-mode').hide();
            $('.edit-mode').show();
            $('#pharmacyActions').addClass('show');
            $(this).html('<i class="fas fa-times me-2"></i> Cancel Edit');
            $(this).removeClass('btn-edit').addClass('btn-cancel');
            
            Swal.fire({
                icon: 'info',
                title: 'Edit Mode Enabled',
                text: 'You can now edit pharmacy information.',
                confirmButtonColor: '#1b5e20',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            isEditMode = false;
            $('.view-mode').show();
            $('.edit-mode').hide();
            $('#pharmacyActions').removeClass('show');
            $(this).html('<i class="fas fa-edit me-2"></i> Edit Information');
            $(this).removeClass('btn-cancel').addClass('btn-edit');
            
            Swal.fire({
                icon: 'info',
                title: 'Edit Cancelled',
                text: 'Changes were not saved.',
                confirmButtonColor: '#1b5e20',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
    
    // Cancel Button inside Pharmacy Form
    $('#cancelPharmacyBtn').on('click', function() {
        isEditMode = false;
        $('.view-mode').show();
        $('.edit-mode').hide();
        $('#pharmacyActions').removeClass('show');
        $('#editPharmacyBtn').html('<i class="fas fa-edit me-2"></i> Edit Information');
        $('#editPharmacyBtn').removeClass('btn-cancel').addClass('btn-edit');
        
        Swal.fire({
            icon: 'info',
            title: 'Edit Cancelled',
            text: 'Changes were discarded.',
            confirmButtonColor: '#1b5e20',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // Pharmacy Form Submit
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
                    confirmButtonColor: '#1b5e20'
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
    
    // File input preview
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
    
    // ===== SAVE BACKUP SETTINGS =====
    $('#saveBackupBtn').on('click', function() {
        var schedule = $('#backup_schedule').val();
        var retention = $('#backup_retention').val();
        
        Swal.fire({
            title: 'Save Backup Settings?',
            html: 'Schedule: <strong>' + schedule + '</strong><br>Retention: <strong>' + retention + ' days</strong>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1b5e20',
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
                                confirmButtonColor: '#1b5e20'
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
    
    // ===== CREATE BACKUP NOW =====
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
                                confirmButtonColor: '#1b5e20'
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