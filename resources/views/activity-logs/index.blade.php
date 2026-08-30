@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<style>
    /* ===== HEADER BOX ===== */
    .activity-header {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        border-radius: 16px;
        padding: 28px 35px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(11, 122, 51, 0.25);
        position: relative;
        overflow: hidden;
    }

    .activity-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .activity-header::after {
        content: '';
        position: absolute;
        bottom: -60%;
        left: 20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .activity-header .header-left {
        position: relative;
        z-index: 1;
    }

    .activity-header .header-left h2 {
        color: #ffffff;
        font-size: 26px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .activity-header .header-left h2 i {
        background: rgba(255, 255, 255, 0.15);
        padding: 10px;
        border-radius: 12px;
        font-size: 20px;
    }

    .activity-header .header-left p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
        margin: 6px 0 0 0;
        padding-left: 54px;
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    .activity-header .header-right {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .activity-header .header-right .btn-header {
        padding: 9px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }

    .activity-header .header-right .btn-header i {
        font-size: 14px;
    }

    .activity-header .header-right .btn-header.btn-clear-old {
        background: rgba(255, 193, 7, 0.9);
        color: #1a1a2e;
    }

    .activity-header .header-right .btn-header.btn-clear-old:hover {
        background: #ffc107;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.35);
    }

    .activity-header .header-right .btn-header.btn-export {
        background: rgba(255, 255, 255, 0.9);
        color: #0b7a33;
    }

    .activity-header .header-right .btn-header.btn-export:hover {
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
    }

    /* ===== STATS CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .stat-card .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .stat-card .stat-icon.green { background: #e8f5e9; color: #2e7d32; }
    .stat-card .stat-icon.blue { background: #e3f2fd; color: #1565c0; }
    .stat-card .stat-icon.orange { background: #fff3e0; color: #e65100; }
    .stat-card .stat-icon.purple { background: #f3e5f5; color: #6a1b9a; }

    .stat-card .stat-number {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        background: white;
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .filter-bar .form-label {
        font-size: 11px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .filter-bar .form-select,
    .filter-bar .form-control {
        font-size: 13px;
        border-radius: 8px;
        border-color: #dee2e6;
        padding: 6px 12px;
    }

    .filter-bar .form-select:focus,
    .filter-bar .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.12);
    }

    /* ===== SCROLLABLE DROPDOWN ===== */
    .form-select-scroll {
        max-height: 200px;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    .form-select-scroll option {
        padding: 6px 12px;
    }

    .form-select-scroll option:hover {
        background-color: #e8f5e9;
    }

    .form-select-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .form-select-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .form-select-scroll::-webkit-scrollbar-thumb {
        background: #0b7a33;
        border-radius: 4px;
    }

    .form-select-scroll::-webkit-scrollbar-thumb:hover {
        background: #056b28;
    }

    .btn-filter {
        background: #28a745;
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        height: 38px;
    }

    .btn-filter:hover {
        background: #218838;
        color: white;
    }

    .btn-reset {
        background: #f8f9fa;
        color: #495057;
        border: 1px solid #dee2e6;
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        height: 38px;
    }

    .btn-reset:hover {
        background: #e9ecef;
    }

    /* ===== TABLE ===== */
    .table-wrapper {
        background: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .table-header {
        padding: 14px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .table-header .badge-count {
        background: #28a745;
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 50px;
    }

    .table-scroll {
        max-height: 480px;
        overflow-y: auto;
    }

    .table-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 4px;
    }

    .table-scroll table {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    .table-scroll thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        padding: 10px 14px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #e9ecef;
        z-index: 5;
        white-space: nowrap;
    }

    .table-scroll tbody td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
        color: #212529;
    }

    .table-scroll tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table-scroll tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== USER AVATAR ===== */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: white;
        flex-shrink: 0;
    }

    .user-avatar.green { background: #28a745; }
    .user-avatar.blue { background: #007bff; }
    .user-avatar.orange { background: #fd7e14; }
    .user-avatar.purple { background: #6f42c1; }
    .user-avatar.red { background: #dc3545; }
    .user-avatar.teal { background: #20c997; }

    .user-name {
        font-weight: 500;
        font-size: 13px;
        color: #1a1a2e;
    }

    .user-email {
        font-size: 11px;
        color: #6c757d;
    }

    /* ===== ACTION BADGE ===== */
    .action-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }

    .action-badge.create { background: #d4edda; color: #155724; }
    .action-badge.update { background: #cce5ff; color: #004085; }
    .action-badge.delete { background: #f8d7da; color: #721c24; }
    .action-badge.deduct { background: #d1ecf1; color: #0c5460; }
    .action-badge.transfer { background: #e8daef; color: #6f42c1; }
    .action-badge.login { background: #d1ecf1; color: #0c5460; }
    .action-badge.logout { background: #e9ecef; color: #495057; }
    .action-badge.other { background: #e9ecef; color: #495057; }

    /* ===== MODULE BADGE ===== */
    .module-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 500;
        background: #f1f3f5;
        color: #495057;
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.failed {
        background: #f8d7da;
        color: #721c24;
    }

    /* ===== DESCRIPTION ===== */
    .description-cell {
        max-width: 280px;
        word-wrap: break-word;
        white-space: normal;
        font-size: 12px;
        color: #495057;
        line-height: 1.4;
    }

    /* ===== DATE/TIME ===== */
    .date-cell {
        white-space: nowrap;
        font-size: 12px;
        line-height: 1.4;
    }

    .date-cell .date {
        font-weight: 500;
        color: #1a1a2e;
    }

    .date-cell .time {
        color: #6c757d;
        font-size: 11px;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        padding: 12px 20px;
        background: #fafbfc;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-wrapper .info {
        font-size: 13px;
        color: #6c757d;
    }

    .pagination-wrapper .info strong {
        color: #1a1a2e;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.4;
    }

    .empty-state p {
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .empty-state small {
        font-size: 13px;
        color: #adb5bd;
    }

    /* ===== CLEAR LOGS MODAL STYLES ===== */
    .clear-logs-modal {
        padding: 4px 0;
    }

    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        color: #856404;
        text-align: left;
    }

    .warning-box i {
        font-size: 18px;
        margin-top: 1px;
        flex-shrink: 0;
    }

    .clear-logs-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }

    .clear-logs-table tr {
        border-bottom: 1px solid #f1f3f5;
    }

    .clear-logs-table tr:last-child {
        border-bottom: none;
    }

    .clear-logs-table td {
        padding: 10px 4px;
        vertical-align: middle;
    }

    .clear-logs-table .label-cell {
        font-weight: 500;
        color: #495057;
        font-size: 14px;
        width: 45%;
        white-space: nowrap;
    }

    .clear-logs-table .input-cell {
        width: 55%;
    }

    .form-select-custom {
        width: 100%;
        padding: 8px 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        color: #1a1a2e;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .form-select-custom:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.12);
    }

    .form-select-custom:hover {
        border-color: #28a745;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .user-info strong {
        font-size: 14px;
        color: #1a1a2e;
    }

    .role-badge {
        background: #e9ecef;
        color: #495057;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ===== SUCCESS BOX ===== */
    .success-box {
        text-align: center;
        padding: 8px 0;
    }

    .success-message {
        font-size: 16px;
        font-weight: 500;
        color: #1a1a2e;
        margin-bottom: 4px;
    }

    .deleted-by {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #e9ecef;
        font-size: 13px;
        color: #6c757d;
    }

    .deleted-by strong {
        color: #1a1a2e;
    }

    .deleted-by .role-badge {
        margin-left: 6px;
    }

    /* ===== SWEETALERT2 OVERRIDES ===== */
    .swal2-popup {
        border-radius: 16px !important;
    }

    .swal2-title {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #1a1a2e !important;
    }

    .swal2-html-container {
        padding: 0 !important;
        margin: 0 !important;
    }

    .swal2-actions {
        margin-top: 20px !important;
    }

    .swal2-actions .swal2-confirm {
        padding: 10px 28px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
    }

    .swal2-actions .swal2-cancel {
        padding: 10px 28px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
    }

    .swal2-actions .swal2-confirm i,
    .swal2-actions .swal2-cancel i {
        margin-right: 6px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .activity-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 22px 25px;
        }

        .activity-header .header-left p {
            padding-left: 0;
        }

        .activity-header .header-right {
            width: 100%;
        }

        .activity-header .header-right .btn-header {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-bar .row {
            flex-direction: column;
        }

        .table-header {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start;
        }

        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .description-cell {
            max-width: 150px;
        }

        .clear-logs-table td {
            display: block;
            width: 100% !important;
            padding: 6px 4px;
        }

        .clear-logs-table .label-cell {
            padding-bottom: 2px;
        }

        .clear-logs-table .input-cell {
            padding-top: 2px;
        }

        .activity-header {
            padding: 18px 20px;
        }

        .activity-header .header-left h2 {
            font-size: 20px;
        }

        .activity-header .header-left h2 i {
            padding: 8px;
            font-size: 16px;
        }

        .activity-header .header-right .btn-header {
            font-size: 12px;
            padding: 7px 14px;
        }
    }
</style>

<div class="container-fluid px-3">

    {{-- ===== HEADER BOX ===== --}}
    <div class="activity-header">
        <div class="header-left">
            <h2>
                <i class="fas fa-clock-rotate-left"></i>
                Activity Logs
            </h2>
            <p><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i> Track all system activities and user actions</p>
        </div>
        @if(auth()->user()->hasRole('Admin'))
        <div class="header-right">
            <button id="clearOldBtn" class="btn-header btn-clear-old">
                <i class="fas fa-clock"></i> Clear Old Logs
            </button>
            <button id="exportBtn" class="btn-header btn-export">
                <i class="fas fa-download"></i> Export
            </button>
        </div>
        @endif
    </div>

    {{-- ===== STATS CARDS ===== --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Total Activities</div>
                    <div class="stat-number" id="statTotal">{{ $total ?? 0 }}</div>
                </div>
                <div class="stat-icon green">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Today</div>
                    <div class="stat-number" id="statToday">{{ $todayCount ?? 0 }}</div>
                </div>
                <div class="stat-icon blue">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Unique Users</div>
                    <div class="stat-number" id="statUsers">{{ $uniqueUsers ?? 0 }}</div>
                </div>
                <div class="stat-icon orange">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Modules</div>
                    <div class="stat-number" id="statModules">{{ $modules->count() ?? 0 }}</div>
                </div>
                <div class="stat-icon purple">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== FILTER BAR ===== --}}
    <div class="filter-bar">
        <div class="row g-2 align-items-end">
            {{-- MODULE FILTER --}}
            <div class="col-md-4">
                <label class="form-label">Module</label>
                <select id="filterModule" class="form-select form-select-scroll">
                    <option value="">All Modules</option>
                    <option value="User & Access">👤 User & Access</option>
                    <option value="Inventory">💊 Inventory</option>
                    <option value="Categories">📂 Categories</option>
                    <option value="Dosage Forms">💉 Dosage Forms</option>
                    <option value="Promos">🏷️ Promos</option>
                    <option value="Discount Types">💰 Discount Types</option>
                    <option value="POS">🛒 POS</option>
                    <option value="Prescriptions">📋 Prescriptions</option>
                    <option value="Sales Reports">📊 Sales Reports</option>
                    <option value="Receipts">🧾 Receipts</option>
                    <option value="Settings">⚙️ Settings</option>
                    <option value="Auth">🔐 Auth</option>
                    <option value="Backup & Recovery">💾 Backup & Recovery</option>
                    <option value="Activity Logs">📜 Activity Logs</option>
                </select>
            </div>

            {{-- DATE RANGE --}}
            <div class="col-md-3">
                <label class="form-label">Date From</label>
                <input type="date" id="startDate" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Date To</label>
                <input type="date" id="endDate" class="form-control">
            </div>

            {{-- BUTTONS --}}
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-1">
                    <button id="applyFilterBtn" class="btn-filter flex-grow-1">
                        <i class="fas fa-search me-1"></i> Apply
                    </button>
                    <button id="resetFilterBtn" class="btn-reset">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="table-wrapper">
        <div class="table-header">
            <h5><i class="fas fa-history text-success me-2"></i> Activity Logs</h5>
            <span class="badge-count" id="logCount">0 records</span>
        </div>
        <div class="table-scroll" id="logsTable">
            @include('activity-logs.partials.table', ['logs' => $logs])
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let searchTimeout;

    function loadLogs() {
        const data = {
            module: $('#filterModule').val(),
            start_date: $('#startDate').val(),
            end_date: $('#endDate').val()
        };

        $.ajax({
            url: '{{ route("activity-logs.filter") }}',
            type: 'POST',
            data: {
                ...data,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#logsTable').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading logs...</p>
                    </div>
                `);
            },
            success: function(response) {
                $('#logsTable').html(response);
                updateCount();
            },
            error: function() {
                $('#logsTable').html(`
                    <div class="empty-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Failed to load logs</p>
                        <small>Please try again</small>
                    </div>
                `);
            }
        });
    }

    function updateCount() {
        const rows = $('#logsTable table tbody tr').length;
        $('#logCount').text(rows + ' records');
        updateStats();
    }

    function updateStats() {
        $.ajax({
            url: '{{ route("activity-logs.stats") }}',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#statTotal').text(response.stats.total);
                    $('#statToday').text(response.stats.today);
                    $('#statUsers').text(response.stats.unique_users);
                    $('#statModules').text(response.stats.modules);
                }
            }
        });
    }

    $('#applyFilterBtn').click(loadLogs);

    $('#resetFilterBtn').click(function() {
        $('#filterModule').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        loadLogs();
    });

    $('.filter-bar input, .filter-bar select').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            loadLogs();
        }
    });

    loadLogs();

    // ===== EXPORT =====
    $('#exportBtn').click(function() {
        Swal.fire({
            title: 'Exporting...',
            text: 'Please wait while we prepare your CSV file.',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch('{{ route("activity-logs.export") }}', {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            const filename = 'activity_logs_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.csv';
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success',
                title: 'Exported!',
                text: 'Activity logs exported successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'Please try again.',
                confirmButtonColor: '#dc3545'
            });
        });
    });

    // ===== CLEAR OLD LOGS =====
    $('#clearOldBtn').click(function() {
        const userName = '{{ auth()->user()->full_name ?? auth()->user()->username }}';
        const userRole = '{{ auth()->user()->roles->first()->name ?? "Admin" }}';
        
        Swal.fire({
            title: 'Clear Old Activity Logs?',
            html: `
                <div class="clear-logs-modal">
                    <div class="warning-box">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>This will permanently remove activity logs older than the selected period.</span>
                    </div>
                    
                    <table class="clear-logs-table">
                        <tr>
                            <td class="label-cell">
                                <i class="fas fa-clock me-2"></i>
                                Delete logs older than:
                            </td>
                            <td class="input-cell">
                                <select id="clearDaysSelect" class="form-select-custom">
                                    <option value="7">7 days</option>
                                    <option value="14">14 days</option>
                                    <option value="30" selected>30 days</option>
                                    <option value="60">60 days</option>
                                    <option value="90">90 days</option>
                                    <option value="180">180 days</option>
                                    <option value="365">1 year</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell">
                                <i class="fas fa-user me-2"></i>
                                Deleted by:
                            </td>
                            <td class="input-cell">
                                <span class="user-info">
                                    <strong>${userName}</strong>
                                    <span class="role-badge">${userRole}</span>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash me-2"></i> Clear Logs',
            cancelButtonText: '<i class="fas fa-times me-2"></i> Cancel',
            width: 520,
            padding: '2em',
            preConfirm: () => {
                const days = document.getElementById('clearDaysSelect').value;
                if (!days) {
                    Swal.showValidationMessage('Please select a period');
                    return false;
                }
                return days;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const days = result.value;
                
                Swal.fire({
                    title: 'Clearing Logs...',
                    text: `Deleting logs older than ${days} days...`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '{{ route("activity-logs.clear-old") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        days: days
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cleared Successfully!',
                                html: `
                                    <div class="success-box">
                                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                        <p class="success-message">${response.message}</p>
                                        <p class="text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            Deleted logs older than ${days} days
                                        </p>
                                        <div class="deleted-by">
                                            <i class="fas fa-user me-1"></i>
                                            Deleted by: <strong>${userName}</strong>
                                            <span class="role-badge">${userRole}</span>
                                        </div>
                                    </div>
                                `,
                                timer: 3000,
                                showConfirmButton: true,
                                confirmButtonColor: '#28a745',
                                confirmButtonText: '<i class="fas fa-check me-2"></i> OK'
                            }).then(() => loadLogs());
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to clear old logs.',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection