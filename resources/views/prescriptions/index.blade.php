@extends('layouts.app')

@section('title', 'Doctor\'s Prescriptions')

@section('content')
<style>
    .header-box {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .header-box h2 {
        margin-bottom: 8px;
        font-weight: 700;
    }
    
    .header-box p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .table-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        padding: 15px 20px;
        border: none;
    }
    
    .table-card .card-header .btn {
        background: rgba(255,255,255,0.2);
        border: none;
        transition: all 0.3s;
    }
    
    .table-card .card-header .btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
    }
    
    .table-card th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        border-bottom: 2px solid #e0e0e0;
        padding: 15px;
    }
    
    .table-card td {
        padding: 15px;
        vertical-align: middle;
    }
    
    .table-card tbody tr:hover {
        background: #f8f9fa;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
    }
    
    .badge-active { background: #28a745; color: white; }
    .badge-used { background: #6c757d; color: white; }
    .badge-expired { background: #dc3545; color: white; }
    .badge-cancelled { background: #ffc107; color: #333; }
    
    .progress-small {
        width: 100px;
        height: 6px;
        background: #e0e0e0;
        border-radius: 3px;
        overflow: hidden;
        display: inline-block;
        margin-left: 8px;
    }
    
    .progress-small .progress-bar {
        height: 100%;
        background: #28a745;
        border-radius: 3px;
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    
    .btn-icon {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .btn-icon:hover {
        transform: translateY(-2px);
    }
    
    .pagination-wrapper {
        padding: 20px;
        background: white;
        border-top: 1px solid #e0e0e0;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 50px;
        margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid">
    <div class="header-box">
        <h2><i class="fas fa-prescription-bottle"></i> Doctor's Prescriptions</h2>
        <p><i class="fas fa-chart-line"></i> Manage and track patient prescriptions</p>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-card">
        <div class="row align-items-end">
            <div class="col-md-4 mb-2 mb-md-0">
                <label class="form-label fw-bold"><i class="fas fa-search"></i> Search</label>
                <input type="text" id="searchPrescription" class="form-control" 
                       placeholder="Search by patient name or RX #..." 
                       value="{{ request('search') }}"
                       style="border-radius: 10px;">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="form-label fw-bold"><i class="fas fa-filter"></i> Status Filter</label>
                <select id="statusFilter" class="form-select" style="border-radius: 10px;">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>📋 Used</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>⚠️ Expired</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <button id="filterBtn" class="btn btn-success w-100" style="border-radius: 10px;">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary w-100" style="border-radius: 10px;">
                    <i class="fas fa-sync-alt"></i> Reset All
                </a>
            </div>
        </div>
    </div>
    
    <!-- Prescriptions Table -->
    <div class="table-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Prescription Records</span>
            <a href="{{ route('prescriptions.create') }}" class="btn">
                <i class="fas fa-plus-circle"></i> New Prescription
            </a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>RX #</th>
                        <th>Patient Information</th>
                        <th>Doctor</th>
                        <th>Date Issued</th>
                        <th>Valid Until</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    @php
                        $totalPrescribed = $prescription->items->sum('quantity_prescribed');
                        $totalDispensed = $prescription->items->sum('quantity_dispensed');
                        $totalRemaining = $prescription->items->sum('quantity_remaining');
                        $progress = $totalPrescribed > 0 ? round(($totalDispensed / $totalPrescribed) * 100) : 0;
                        
                        // Check if expired
                        $isExpired = $prescription->status == 'active' && $prescription->valid_until && $prescription->valid_until < now();
                        $displayStatus = $isExpired ? 'expired' : $prescription->status;
                    @endphp
                    <tr>
                        <td>
                            <strong class="text-success">{{ $prescription->prescription_number }}</strong>
                        </td>
                        <td>
                            <strong>{{ $prescription->patient_name }}</strong><br>
                            <small class="text-muted">
                                <i class="fas fa-birthday-cake"></i> {{ $prescription->patient_age ?? 'N/A' }} yrs old
                            </small><br>
                            @if($prescription->patient_contact)
                            <small class="text-muted">
                                <i class="fas fa-phone"></i> {{ $prescription->patient_contact }}
                            </small>
                            @endif
                        </td>
                        <td>
                            {{ $prescription->doctor_name }}<br>
                            @if($prescription->doctor_license)
                            <small class="text-muted">LIC: {{ $prescription->doctor_license }}</small>
                            @endif
                        </td>
                        <td>
                            <i class="fas fa-calendar-alt text-success"></i><br>
                            {{ $prescription->date_issued->format('M d, Y') }}
                        </td>
                        <td>
                            @if($prescription->valid_until)
                                <i class="fas fa-hourglass-half text-warning"></i><br>
                                {{ $prescription->valid_until->format('M d, Y') }}
                                @if($prescription->valid_until < now())
                                    <br><small class="text-danger">(Expired)</small>
                                @endif
                            @else
                                <span class="text-muted">No expiry</span>
                            @endif
                        </td>
                        <td style="min-width: 120px;">
                            <div class="d-flex align-items-center">
                                <span class="fw-bold">{{ $progress }}%</span>
                                <div class="progress-small">
                                    <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            <small class="text-muted">
                                {{ $totalDispensed }} / {{ $totalPrescribed }} dispensed
                            </small>
                            @if($totalRemaining > 0)
                                <br><small class="text-warning">⏳ {{ $totalRemaining }} left</small>
                            @endif
                        </td>
                        <td>
                            @if($displayStatus == 'active')
                                <span class="badge badge-active"><i class="fas fa-play"></i> Active</span>
                            @elseif($displayStatus == 'used')
                                <span class="badge badge-used"><i class="fas fa-check"></i> Used</span>
                            @elseif($displayStatus == 'expired')
                                <span class="badge badge-expired"><i class="fas fa-clock"></i> Expired</span>
                            @else
                                <span class="badge badge-cancelled"><i class="fas fa-ban"></i> Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-sm btn-info btn-icon" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('prescriptions.print', $prescription) }}" target="_blank" class="btn btn-sm btn-secondary btn-icon" title="Print">
                                    <i class="fas fa-print"></i>
                                </a>
                                @if($prescription->status == 'active' && !$isExpired)
                                    <a href="{{ route('prescriptions.edit', $prescription) }}" class="btn btn-sm btn-primary btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('prescriptions.destroy', $prescription) }}" method="POST" class="d-inline delete-form" 
      data-prescription="{{ $prescription->prescription_number }}" data-patient="{{ $prescription->patient_name }}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger btn-icon delete-btn" title="Delete">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-prescription-bottle"></i>
                                <h5>No Prescriptions Found</h5>
                                <p class="text-muted">Click "New Prescription" to create one.</p>
                                <a href="{{ route('prescriptions.create') }}" class="btn btn-success mt-2">
                                    <i class="fas fa-plus"></i> Create First Prescription
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($prescriptions->hasPages())
        <div class="pagination-wrapper">
            {{ $prescriptions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-filter kapag nag-change ng status
    $('#statusFilter').on('change', function() {
        applyFilter();
    });
    
    // Search button click
    $('#filterBtn').on('click', function() {
        applyFilter();
    });
    
    // Press Enter sa search field
    $('#searchPrescription').on('keypress', function(e) {
        if (e.which === 13) {
            applyFilter();
        }
    });
    
    function applyFilter() {
        let search = $('#searchPrescription').val();
        let status = $('#statusFilter').val();
        let url = "{{ route('prescriptions.index') }}";
        let params = [];
        
        if (search && search.trim() !== '') {
            params.push('search=' + encodeURIComponent(search.trim()));
        }
        if (status && status !== 'all') {
            params.push('status=' + encodeURIComponent(status));
        }
        
        if (params.length > 0) {
            window.location.href = url + '?' + params.join('&');
        } else {
            window.location.href = url;
        }
    }
    
    // ========== DELETE WITH SWEETALERT ==========
    $(document).on('click', '.delete-btn', function() {
        let form = $(this).closest('.delete-form');
        let prescriptionNumber = form.data('prescription');
        let patientName = form.data('patient');
        
        Swal.fire({
            title: 'Delete Prescription?',
            html: `Are you sure you want to delete <strong>${prescriptionNumber}</strong><br>for patient <strong>${patientName}</strong>?`,
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash-alt"></i> Yes, delete it!',
            cancelButtonText: '<i class="fas fa-times"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form via AJAX
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Prescription has been deleted.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Something went wrong.',
                                confirmButtonColor: '#d33'
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to delete prescription.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Delete Failed!',
                            text: errorMsg,
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