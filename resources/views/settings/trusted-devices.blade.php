@extends('layouts.app')

@section('title', 'Trusted Devices')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - TRUSTED DEVICES
       ============================================ */

    /* ===== HEADER ===== */
    .header-gradient {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        border-radius: 16px;
        padding: 20px 30px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .header-gradient h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-gradient h4 i {
        font-size: 24px;
    }

    .header-gradient p {
        margin: 4px 0 0 0;
        opacity: 0.85;
        font-size: 14px;
        padding-left: 44px;
    }

    /* ===== DEVICE CARD ===== */
    .device-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
        background: white;
        border: 1px solid #eef2f6;
        margin-bottom: 12px;
    }

    .device-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .device-card .card-body {
        padding: 14px 18px;
    }

    .device-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .device-icon.current {
        background: #e3f2fd;
        color: #1565c0;
    }

    .device-icon.other {
        background: #f5f5f5;
        color: #666;
    }

    .device-icon.mobile {
        background: #fff3e0;
        color: #e65100;
    }

    .device-card h6 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .device-card .text-muted {
        font-size: 12px;
        color: #6c757d;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 8px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-outline-danger {
        color: #dc3545;
        border: 1.5px solid #dc3545;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-danger-sm {
        padding: 4px 12px;
        font-size: 12px;
        border-radius: 20px;
    }

    .btn-outline-danger-rounded {
        border-radius: 20px;
        padding: 6px 20px;
    }

    /* ===== BADGES ===== */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-success {
        background: #0b7a33 !important;
        color: white;
    }

    .badge.bg-primary {
        background: #007bff !important;
        color: white;
    }

    .badge.bg-secondary {
        background: #6c757d !important;
        color: white;
    }

    /* ===== CARDS ===== */
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 20px;
    }

    .card-header h5 {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .card-body {
        padding: 20px;
    }

    /* ===== ALERTS ===== */
    .alert {
        font-size: 14px;
        border-radius: 10px;
        padding: 12px 18px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-success {
        background: #e8f5e9;
        color: #0b7a33;
    }

    .alert-danger {
        background: #ffebee;
        color: #c62828;
    }

    /* ===== INFO CARD ===== */
    .info-card .device-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: #e8f5e9;
        color: #0b7a33;
    }

    .info-card h6 {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .info-card p {
        font-size: 13px;
        color: #6c757d;
        margin: 0;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state i {
        font-size: 48px;
        opacity: 0.3;
        color: #0b7a33;
        margin-bottom: 12px;
    }

    .empty-state h5 {
        font-size: 18px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .empty-state p {
        font-size: 14px;
        color: #adb5bd;
        margin-bottom: 0;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-gradient {
            padding: 16px 20px;
        }
        .header-gradient h4 {
            font-size: 20px;
        }
        .header-gradient p {
            padding-left: 0;
            font-size: 13px;
        }
        .device-card .card-body {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
        .device-card .btn {
            width: 100%;
            justify-content: center;
        }
        .empty-state i {
            font-size: 40px;
        }
        .empty-state h5 {
            font-size: 16px;
        }
        .empty-state p {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .header-gradient h4 {
            font-size: 18px;
        }
        .header-gradient h4 i {
            font-size: 18px;
        }
        .header-gradient p {
            font-size: 12px;
        }
        .card-header h5 {
            font-size: 14px;
        }
        .device-card h6 {
            font-size: 14px;
        }
        .device-card .text-muted {
            font-size: 11px;
        }
        .device-icon {
            width: 38px;
            height: 38px;
            font-size: 18px;
        }
        .badge {
            font-size: 10px;
            padding: 2px 10px;
        }
        .btn {
            font-size: 12px;
            padding: 5px 14px;
        }
        .alert {
            font-size: 13px;
            padding: 10px 14px;
        }
        .info-card h6 {
            font-size: 14px;
        }
        .info-card p {
            font-size: 12px;
        }
        .empty-state h5 {
            font-size: 15px;
        }
        .empty-state p {
            font-size: 12px;
        }
        .empty-state i {
            font-size: 36px;
        }
    }
</style>

<div class="container-fluid px-3">
    <!-- ===== HEADER ===== -->
    <div class="header-gradient">
        <h4>
            <i class="fas fa-shield-alt"></i>
            Trusted Devices
        </h4>
        <p>Manage your trusted devices for OTP verification</p>
    </div>

    <!-- ===== ALERTS ===== -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- ===== INFO CARD ===== -->
    <div class="card border-0 shadow-sm mb-4 info-card">
        <div class="card-body d-flex align-items-center gap-3">
            <div class="device-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h6>What are trusted devices?</h6>
                <p>Trusted devices allow you to bypass OTP verification on devices you frequently use. You can manage your trusted devices here.</p>
            </div>
        </div>
    </div>

    <!-- ===== TRUSTED DEVICES LIST ===== -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5>
                <i class="fas fa-laptop text-success me-2"></i> Your Trusted Devices
            </h5>
            <span class="badge bg-success rounded-pill">{{ $devices->count() }} device(s)</span>
        </div>
        <div class="card-body">
            @forelse($devices as $device)
            <div class="device-card card shadow-sm" id="device-{{ $device->device_id }}">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="device-icon 
                            {{ $device->is_current ?? false ? 'current' : 'other' }}
                            {{ str_contains(strtolower($device->device_name ?? ''), 'mobile') ? 'mobile' : '' }}">
                            <i class="fas 
                                {{ str_contains(strtolower($device->device_name ?? ''), 'mobile') ? 'fa-mobile-alt' : 'fa-laptop' }}">
                            </i>
                        </div>
                        <div>
                            <h6>
                                {{ $device->device_name ?? 'Unknown Device' }}
                                @if($device->is_current ?? false)
                                    <span class="badge bg-primary ms-2">Current Device</span>
                                @endif
                            </h6>
                            <div class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i> 
                                {{ $device->ip_address ?? 'Unknown location' }}
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-clock me-1"></i> 
                                Last used: {{ $device->last_used_at ? \Carbon\Carbon::parse($device->last_used_at)->diffForHumans() : 'Never' }}
                            </div>
                            <div class="text-muted">
                                <i class="fas fa-calendar me-1"></i> 
                                Added: {{ $device->created_at ? \Carbon\Carbon::parse($device->created_at)->diffForHumans() : 'Recently' }}
                            </div>
                        </div>
                    </div>
                    @if(!($device->is_current ?? false))
                    <button type="button" class="btn btn-outline-danger btn-outline-danger-rounded remove-device" 
                            data-device-id="{{ $device->device_id }}">
                        <i class="fas fa-trash me-1"></i> Remove
                    </button>
                    @else
                    <span class="badge bg-secondary">
                        <i class="fas fa-check-circle me-1"></i> Active
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5 empty-state">
                <i class="fas fa-laptop"></i>
                <h5>No trusted devices found</h5>
                <p>When you log in with OTP, devices can be added as trusted.</p>
            </div>
            @endforelse

            @if($devices->count() > 1)
            <div class="mt-3 text-end">
                <button type="button" class="btn btn-outline-danger btn-outline-danger-rounded" id="clearAllDevices">
                    <i class="fas fa-trash-alt me-2"></i> Clear All Devices
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // ============================================
    // REMOVE SINGLE DEVICE
    // ============================================
    $('.remove-device').on('click', function() {
        let deviceId = $(this).data('device-id');
        let btn = $(this);
        let card = btn.closest('.device-card');
        
        Swal.fire({
            title: 'Remove Device?',
            text: 'This device will no longer be trusted for OTP verification.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/trusted-devices/' + deviceId,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            card.fadeOut(300, function() {
                                $(this).remove();
                                let count = $('.device-card:visible').length;
                                $('.badge.bg-success.rounded-pill').text(count + ' device(s)');
                                if (count === 0) {
                                    location.reload();
                                }
                            });
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: response.message || 'Device removed successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to remove device.'
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to remove device.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message
                        });
                    }
                });
            }
        });
    });

    // ============================================
    // CLEAR ALL DEVICES
    // ============================================
    $('#clearAllDevices').on('click', function() {
        Swal.fire({
            title: 'Clear All Devices?',
            text: 'This will remove all trusted devices. You will need to verify OTP on every device.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear all',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/trusted-devices/clear-all',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cleared!',
                                text: response.message || 'All devices cleared.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to clear devices.'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to clear devices.'
                        });
                    }
                });
            }
        });
    });
});

console.log('✅ Trusted Devices page loaded successfully!');
</script>
@endsection