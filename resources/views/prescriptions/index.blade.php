@extends('layouts.app')

@section('title', 'Doctor\'s Prescriptions')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .header-box {
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 12px;
        padding: 20px 30px;
        margin-bottom: 30px;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .header-box h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-box h2 i {
        margin-right: 8px;
    }

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e9ecef;
    }

    .filter-card .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 13px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        padding: 8px 12px;
        height: 38px;
        width: 100%;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

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

    .btn-success {
        background: #0b7a33;
        border-color: #0b7a33;
        color: white;
    }

    .btn-success:hover {
        background: #056b28;
        border-color: #056b28;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #5a6268;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
        border-color: #138496;
        color: white;
    }

    .btn-primary {
        background: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0069d9;
        border-color: #0069d9;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        border-color: #c82333;
        color: white;
    }

    .table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e9ecef;
    }

    .table-card .card-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 12px 20px;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-card .card-header span {
        font-size: 16px;
        font-weight: 600;
    }

    .table-card .card-header .btn {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .table-card .card-header .btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        font-size: 13px;
        margin: 0;
        width: 100%;
    }

    .table thead th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 2px solid #e9ecef;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        font-size: 13px;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background: #f8fdf8;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-active { background: #28a745; color: white; }
    .badge-used { background: #6c757d; color: white; }
    .badge-expired { background: #dc3545; color: white; }
    .badge-cancelled { background: #ffc107; color: #333; }

    .progress-small {
        width: 80px;
        height: 6px;
        background: #e9ecef;
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
        gap: 4px;
        flex-wrap: wrap;
    }

    .btn-icon {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
    }

    .pagination-wrapper {
        padding: 10px 18px;
        background: #fafbfc;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-wrapper .pagination-info {
        font-size: 13px;
        color: #6c757d;
    }

    .pagination-wrapper .pagination-info strong {
        color: #1a1a2e;
    }

    .pagination {
        display: flex;
        gap: 3px;
        margin: 0;
        padding: 0;
        list-style: none;
        align-items: center;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        background: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: #e8f5e9;
        border-color: #0b7a33;
        color: #0b7a33;
    }

    .pagination .page-item.active .page-link {
        background: #0b7a33;
        border-color: #0b7a33;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.3;
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
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .header-box {
            padding: 16px 20px;
        }
        .header-box h2 {
            font-size: 20px;
        }
        .filter-card .row {
            flex-direction: column;
            gap: 10px;
        }
        .filter-card .col-md-3,
        .filter-card .col-md-2,
        .filter-card .col-md-4 {
            width: 100%;
        }
        .action-buttons {
            flex-direction: column;
        }
        .table thead th,
        .table tbody td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .pagination .page-link {
            font-size: 12px;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .table {
            font-size: 12px;
        }
        .table thead th {
            font-size: 10px;
        }
        .badge {
            font-size: 10px;
            padding: 2px 8px;
        }
        .btn-icon {
            font-size: 11px;
            padding: 3px 8px;
        }
        .table-card .card-header {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
        .table-card .card-header .btn {
            width: 100%;
            justify-content: center;
        }
    }

    .search-indicator {
        font-size: 12px;
        color: #6c757d;
        padding: 4px 10px;
        background: #f8f9fa;
        border-radius: 6px;
        display: inline-block;
        margin-left: 10px;
    }

    .search-indicator .highlight {
        color: #0b7a33;
        font-weight: 600;
    }

    .table tbody tr.highlight-row {
        background: #fff3cd !important;
        transition: background 0.3s ease;
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-prescription-bottle"></i>
            Doctor's Prescriptions
            <span id="resultCount" class="search-indicator" style="display: none;">
                <i class="fas fa-search"></i> Found <span class="highlight" id="resultCountNumber">0</span> results
            </span>
        </h2>
    </div>

    <!-- ===== FILTER SECTION ===== -->
    <div class="filter-card">
        <div class="row align-items-end">
            <div class="col-md-4 mb-2 mb-md-0">
                <label class="form-label">
                    <i class="fas fa-search"></i> Search for Patient Information
                </label>
                <input type="text" id="searchPrescription" class="form-control" 
                       placeholder="Search by patient name or RX #..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="form-label">
                    <i class="fas fa-filter"></i> Status Filter
                </label>
                <select id="statusFilter" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>📋 Used</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>⚠️ Expired</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                </select>
            </div>
            <div class="col-md-2 mb-2 mb-md-0">
                <button id="filterBtn" class="btn btn-success w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt"></i> Reset All
                </a>
            </div>
        </div>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="table-card">
        <div class="card-header">
            <span><i class="fas fa-list"></i> Prescription Records</span>
            <a href="{{ route('prescriptions.create') }}" class="btn">
                <i class="fas fa-plus-circle"></i> New Prescription
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="prescriptionTable">
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
                <tbody id="prescriptionTableBody">
                    @forelse($prescriptions as $prescription)
                    @php
                        $totalPrescribed = $prescription->items->sum('quantity_prescribed');
                        $totalDispensed = $prescription->items->sum('quantity_dispensed');
                        $totalRemaining = $prescription->items->sum('quantity_remaining');
                        $progress = $totalPrescribed > 0 ? round(($totalDispensed / $totalPrescribed) * 100) : 0;

                        $isExpired = $prescription->status == 'active' && $prescription->valid_until && $prescription->valid_until < now();
                        $displayStatus = $isExpired ? 'expired' : $prescription->status;
                    @endphp
                    <tr class="prescription-row" data-prescription-id="{{ $prescription->id }}">
                        <td>
                            <strong class="text-success" style="font-size: 13px;">{{ $prescription->prescription_number }}</strong>
                        </td>
                        <td class="patient-name-cell">
                            <strong>{{ $prescription->patient_name }}</strong><br>
                            <small class="text-muted" style="font-size: 12px;">
                                <i class="fas fa-birthday-cake"></i> {{ $prescription->patient_age ?? 'N/A' }} yrs old
                            </small><br>
                            @if($prescription->patient_contact)
                            <small class="text-muted" style="font-size: 12px;">
                                <i class="fas fa-phone"></i> {{ $prescription->patient_contact }}
                            </small>
                            @endif
                        </td>
                        <td>
                            {{ $prescription->doctor_name }}<br>
                            @if($prescription->doctor_license)
                            <small class="text-muted" style="font-size: 12px;">LIC: {{ $prescription->doctor_license }}</small>
                            @endif
                        </td>
                        <td style="font-size: 12px;">
                            <i class="fas fa-calendar-alt text-success"></i><br>
                            {{ $prescription->date_issued->format('M d, Y') }}
                        </td>
                        <td>
                            @if($prescription->valid_until)
                                <i class="fas fa-hourglass-half text-warning"></i><br>
                                <span style="font-size: 12px;">{{ $prescription->valid_until->format('M d, Y') }}</span>
                                @if($prescription->valid_until < now())
                                    <br><small class="text-danger" style="font-size: 11px;">(Expired)</small>
                                @endif
                            @else
                                <span class="text-muted" style="font-size: 12px;">No expiry</span>
                            @endif
                        </td>
                        <td style="min-width: 120px;">
                            <div class="d-flex align-items-center">
                                <span class="fw-bold" style="font-size: 13px;">{{ $progress }}%</span>
                                <div class="progress-small">
                                    <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">
                                {{ $totalDispensed }} / {{ $totalPrescribed }} dispensed
                            </small>
                            @if($totalRemaining > 0)
                                <br><small class="text-warning" style="font-size: 11px;">⏳ {{ $totalRemaining }} left</small>
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
                    <tr id="emptyRow">
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-prescription-bottle"></i>
                                <h5>No Prescriptions Found</h5>
                                <p>Click "New Prescription" to create one.</p>
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
            <div class="pagination-info">
                <i class="fas fa-list-ul me-1 text-muted"></i>
                Showing <strong id="firstItem">{{ $prescriptions->firstItem() ?? 0 }}</strong> to <strong id="lastItem">{{ $prescriptions->lastItem() ?? 0 }}</strong> of <strong id="totalItems">{{ $prescriptions->total() }}</strong> results
            </div>
            <div id="paginationLinks">
                {{ $prescriptions->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // ============================================
    // LIVE SEARCH
    // ============================================
    
    let searchTimeout = null;

    function performLiveSearch() {
        let searchTerm = $('#searchPrescription').val().trim().toLowerCase();
        let statusFilter = $('#statusFilter').val();
        
        let visibleCount = 0;
        let hasVisibleRows = false;
        
        $('#prescriptionTableBody tr.prescription-row').each(function() {
            let $row = $(this);
            let $patientName = $row.find('.patient-name-cell strong');
            let $rxNumber = $row.find('td:first strong');
            
            let patientText = $patientName.text().toLowerCase();
            let rxText = $rxNumber.text().toLowerCase();
            
            let matchesSearch = true;
            let matchesStatus = true;
            
            if (searchTerm !== '') {
                matchesSearch = patientText.includes(searchTerm) || rxText.includes(searchTerm);
            }
            
            if (statusFilter !== 'all') {
                let statusBadge = $row.find('td .badge');
                let statusText = statusBadge.text().trim().toLowerCase();
                let filterMap = {
                    'active': 'active',
                    'used': 'used',
                    'expired': 'expired',
                    'cancelled': 'cancelled'
                };
                matchesStatus = statusText === filterMap[statusFilter];
            }
            
            if (matchesSearch && matchesStatus) {
                $row.show();
                visibleCount++;
                hasVisibleRows = true;
                
                if (searchTerm !== '' && matchesSearch) {
                    $row.addClass('highlight-row');
                } else {
                    $row.removeClass('highlight-row');
                }
            } else {
                $row.hide();
                $row.removeClass('highlight-row');
            }
        });
        
        let $resultCount = $('#resultCount');
        let $resultCountNumber = $('#resultCountNumber');
        
        if (searchTerm !== '' || statusFilter !== 'all') {
            $resultCount.show();
            $resultCountNumber.text(visibleCount);
            
            let filterText = '';
            if (searchTerm !== '' && statusFilter !== 'all') {
                filterText = `"${searchTerm}" with status: ${statusFilter}`;
            } else if (searchTerm !== '') {
                filterText = `"${searchTerm}"`;
            } else {
                filterText = `status: ${statusFilter}`;
            }
            $resultCount.html(`<i class="fas fa-search"></i> Found <span class="highlight">${visibleCount}</span> results for ${filterText}`);
        } else {
            $resultCount.hide();
        }
        
        if (!hasVisibleRows && $('#prescriptionTableBody tr.prescription-row').length > 0) {
            if ($('#emptyRow').length === 0) {
                let emptyHtml = `
                    <tr id="emptyRow">
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-search"></i>
                                <h5>No Matching Prescriptions</h5>
                                <p>Try adjusting your search or filters.</p>
                                <button class="btn btn-secondary mt-2" onclick="resetFilters()">
                                    <i class="fas fa-sync-alt"></i> Reset Filters
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $('#prescriptionTableBody').append(emptyHtml);
            }
        } else {
            $('#emptyRow').remove();
        }
    }

    $('#searchPrescription').on('input', function() {
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }
        searchTimeout = setTimeout(function() {
            performLiveSearch();
        }, 100);
    });

    $('#statusFilter').on('change', function() {
        performLiveSearch();
    });

    $('#filterBtn').on('click', function() {
        performLiveSearch();
    });

    $('#searchPrescription').on('keypress', function(e) {
        if (e.which === 13) {
            performLiveSearch();
        }
    });

    window.resetFilters = function() {
        $('#searchPrescription').val('');
        $('#statusFilter').val('all');
        performLiveSearch();
    };

    // ============================================
    // DELETE WITH SUCCESS NOTIFICATION
    // ============================================
    $(document).on('click', '.delete-btn', function() {
        let form = $(this).closest('.delete-form');
        let prescriptionNumber = form.data('prescription');
        let patientName = form.data('patient');
        
        Swal.fire({
            title: '🗑️ Delete Prescription?',
            html: `
                <div style="text-align: left; padding: 10px;">
                    <p style="font-size: 15px; margin-bottom: 8px;">
                        <strong>RX #:</strong> ${prescriptionNumber}
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                        <strong>Patient:</strong> ${patientName}
                    </p>
                    <hr style="margin: 10px 0;">
                    <p style="font-size: 14px; color: #dc3545; font-weight: 600;">
                        ⚠️ This action cannot be undone!
                    </p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash-alt"></i> Yes, delete it!',
            cancelButtonText: '<i class="fas fa-times"></i> Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            // ✅ SUCCESS NOTIFICATION
                            Swal.fire({
                                icon: 'success',
                                title: '🗑️ Deleted!',
                                html: `
                                    <div style="text-align: left; padding: 10px;">
                                        <p style="font-size: 15px; margin-bottom: 8px;">
                                            <strong>RX #:</strong> ${response.prescription_number || prescriptionNumber}
                                        </p>
                                        <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                                            <strong>Patient:</strong> ${response.patient_name || patientName}
                                        </p>
                                        <hr style="margin: 10px 0;">
                                        <p style="font-size: 14px; color: #0b7a33; font-weight: 600;">
                                            ✅ Prescription deleted successfully!
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: '👌 OK',
                                confirmButtonColor: '#0b7a33',
                                timer: 2500,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '❌ Error!',
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
                            title: '❌ Delete Failed!',
                            text: errorMsg,
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });

    // ============================================
    // INITIALIZE
    // ============================================
    if ($('#searchPrescription').val().trim() !== '' || $('#statusFilter').val() !== 'all') {
        performLiveSearch();
    }

    console.log('✅ Prescriptions page loaded with LIVE SEARCH and DELETE NOTIFICATION!');
});
</script>
@endsection