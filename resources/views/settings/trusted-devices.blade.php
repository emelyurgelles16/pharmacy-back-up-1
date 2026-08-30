@extends('layouts.app')

@section('title', 'Trusted Devices')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .device-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
    }
    .device-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .device-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: #e8f5e9;
        color: #1b5e20;
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
    .header-gradient {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        border-radius: 20px;
    }
</style>

<div class="container-fluid px-3">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 header-gradient">
                <div class="card-body py-4">
                    <h4 class="mb-1 text-white">
                        <i class="fas fa-shield-alt me-2"></i> Trusted Devices
                    </h4>
                    <p class="mb-0 text-white-50">Manage your trusted devices for OTP verification</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
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

    <!-- Info Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3">
                <div class="device-icon current">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-semibold">What are trusted devices?</h6>
                    <p class="mb-0 text-muted small">
                        Trusted devices allow you to bypass OTP verification on devices you frequently use.
                        You can manage your trusted devices here.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trusted Devices List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-laptop text-success me-2"></i> Your Trusted Devices
            </h5>
            <span class="badge bg-success rounded-pill">{{ $devices->count() }} device(s)</span>
        </div>
        <div class="card-body">
            @forelse($devices as $device)
            <div class="device-card card mb-3 shadow-sm" id="device-{{ $device->device_id }}">
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
                            <h6 class="mb-0 fw-semibold">
                                {{ $device->device_name ?? 'Unknown Device' }}
                                @if($device->is_current ?? false)
                                    <span class="badge bg-primary ms-2">Current Device</span>
                                @endif
                            </h6>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i> 
                                {{ $device->ip_address ?? 'Unknown location' }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> 
                                Last used: {{ $device->last_used_at ? \Carbon\Carbon::parse($device->last_used_at)->diffForHumans() : 'Never' }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i> 
                                Added: {{ $device->created_at ? \Carbon\Carbon::parse($device->created_at)->diffForHumans() : 'Recently' }}
                            </small>
                        </div>
                    </div>
                    @if(!($device->is_current ?? false))
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill remove-device" 
                            data-device-id="{{ $device->device_id }}">
                        <i class="fas fa-trash me-1"></i> Remove
                    </button>
                    @else
                    <span class="badge bg-secondary rounded-pill">
                        <i class="fas fa-check-circle me-1"></i> Active
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-laptop fa-4x text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No trusted devices found</h5>
                <p class="text-muted">When you log in with OTP, devices can be added as trusted.</p>
                <a href="{{ route('settings.profile') }}" class="btn btn-success rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i> Back to Profile
                </a>
            </div>
            @endforelse

            @if($devices->count() > 1)
            <div class="mt-3 text-end">
                <button type="button" class="btn btn-outline-danger rounded-pill" id="clearAllDevices">
                    <i class="fas fa-trash-alt me-2"></i> Clear All Devices
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-3">
        <a href="{{ route('settings.profile') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Profile
        </a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Remove single device
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
            confirmButtonText: 'Yes, remove it'
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
                                // Update count
                                let count = $('.device-card:visible').length;
                                $('.badge.bg-success.rounded-pill').text(count + ' device(s)');
                                
                                // If no devices left, reload
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

    // Clear all devices
    $('#clearAllDevices').on('click', function() {
        Swal.fire({
            title: 'Clear All Devices?',
            text: 'This will remove all trusted devices. You will need to verify OTP on every device.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear all'
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