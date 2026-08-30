@extends('layouts.app')

@section('title', 'My Activity Logs')

@section('content')
<style>
    .header-box {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: #fff;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .header-box h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .header-box h2 i {
        margin-right: 10px;
    }

    .header-box p {
        margin: 8px 0 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .table-box {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Table Container - Only Vertical Scroll */
    .table-container {
        max-height: 550px;
        overflow-y: auto;
        overflow-x: auto;
    }

    .table-container table {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    .table-container th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        padding: 12px 10px;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 2px solid #e9ecef;
        text-align: left;
        z-index: 10;
    }

    .table-container td {
        padding: 10px 10px;
        font-size: 13px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-container tr:hover {
        background-color: #f8f9fa;
    }

    /* Custom Scrollbar */
    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .badge-action {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-create { background: #28a745; color: white; }
    .badge-update { background: #ffc107; color: #333; }
    .badge-delete { background: #dc3545; color: white; }
    .badge-deduct { background: #17a2b8; color: white; }
    .badge-transfer { background: #6f42c1; color: white; }
    .badge-login { background: #007bff; color: white; }
    .badge-logout { background: #6c757d; color: white; }
    .badge-other { background: #6c757d; color: white; }

    .empty-state {
        text-align: center;
        color: #adb5bd;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .btn-filter {
        background: #0b7a33;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-filter:hover {
        background: #056b28;
    }

    .btn-reset {
        background: #6c757d;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .search-input {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 8px 15px;
        width: 100%;
    }

    .search-input:focus {
        border-color: #0b7a33;
        outline: none;
        box-shadow: 0 0 0 2px rgba(11, 122, 51, 0.1);
    }
</style>

<div class="container-fluid px-3">
    <div class="header-box">
        <div>
            <h2><i class="fas fa-clock-rotate-left me-2"></i> My Activity Logs</h2>
            <p>Track your personal activities and actions in the system</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold mb-1">
                    <i class="fas fa-search me-1"></i> Search
                </label>
                <input type="text" id="searchInput" class="search-input" placeholder="Search by action, module, or description...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold mb-1">
                    <i class="fas fa-calendar me-1"></i> Start Date
                </label>
                <input type="date" id="startDate" class="search-input">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold mb-1">
                    <i class="fas fa-calendar me-1"></i> End Date
                </label>
                <input type="date" id="endDate" class="search-input">
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button id="applyFilterBtn" class="btn-filter">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <button id="resetFilterBtn" class="btn-reset">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-box">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold text-success">
                <i class="fas fa-history me-2"></i> Your Activity Logs
            </h5>
            <span class="badge bg-success" id="logCount">0 records</span>
        </div>
        
        <div class="table-container" id="logsTable">
            @include('activity-logs.partials.table', ['logs' => $logs])
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let searchTimeout;

    function loadLogs() {
        let filters = {
            search: $('#searchInput').val(),
            start_date: $('#startDate').val(),
            end_date: $('#endDate').val()
        };
        
        $('#logsTable').html('<div class="text-center py-5"><i class="fas fa-spinner fa-pulse fa-2x text-success"></i><p class="mt-2">Loading logs...</p></div>');
        
        $.ajax({
            url: '{{ route("settings.activity-logs.filter") }}',
            method: 'POST',
            data: {
                ...filters,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#logsTable').html(response);
                const rowCount = $('#logsTable table tbody tr').length;
                $('#logCount').text(rowCount + ' records');
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#logsTable').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load logs. Please try again.</p></div>');
            }
        });
    }
    
    // Apply filter button
    $('#applyFilterBtn').click(function() { loadLogs(); });
    
    // Reset filter button
    $('#resetFilterBtn').click(function() {
        $('#searchInput').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        loadLogs();
    });
    
    // Search with debounce (auto-search after typing)
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadLogs();
        }, 500);
    });
    
    // Date filters auto-search
    $('#startDate, #endDate').on('change', function() {
        loadLogs();
    });
    
    // Initial load
    loadLogs();
});
</script>
@endsection