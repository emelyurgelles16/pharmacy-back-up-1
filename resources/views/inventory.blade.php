@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $isCashier = auth()->user()->hasRole('Cashier');
@endphp

<style>
    /* === Header Box === */ 
    .header-box {
        background: linear-gradient(135deg, #056b28, #0a8a3a);
        color: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(5, 107, 40, 0.3);
    }

    .header-box h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    /* === TABS === */
    @if($isCashier)
    .inventory-tabs {
        display: none !important;
    }
    @endif

    .inventory-tabs {
        display: flex;
        background: white;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #e8f5e9;
    }

    .tab {
        flex: 1;
        padding: 15px 20px;
        text-align: center;
        text-decoration: none;
        color: #666;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #fafafa;
    }

    .tab:hover {
        background: #f1f8e9;
        color: #1b5e20;
        transform: translateY(-1px);
    }

    .tab.active {
        color: #1b5e20;
        border-bottom: 3px solid #1b5e20;
        background: #e8f5e9;
        box-shadow: 0 -2px 10px rgba(27, 94, 32, 0.1);
    }

    .tab .badge-count {
        background: #1b5e20;
        color: white;
        border-radius: 50%;
        padding: 2px 10px;
        font-size: 12px;
        font-weight: 700;
    }

    /* === Toolbar === */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
        background: white;
        padding: 18px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toolbar label {
        margin-right: 6px;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
        font-size: 13px;
    }

    .toolbar select,
    .toolbar input,
    .toolbar button {
        padding: 10px 16px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        outline: none;
        height: 42px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .toolbar input:focus,
    .toolbar select:focus {
        border-color: #1b5e20;
        box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.15);
    }

    .toolbar input {
        width: 220px;
    }

    .toolbar button {
        background: #1b5e20;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        white-space: nowrap;
        border-radius: 8px;
        padding: 10px 22px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .toolbar button:hover {
        background: #2e7d32;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(27, 94, 32, 0.3);
    }

    /* === FILTER CONTAINER === */
    .filter-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
        z-index: 100;
    }

    .filter-dropdown {
        min-width: 160px;
        background: white;
        border: 1px solid #d0d0d0;
        border-radius: 8px;
        padding: 8px 14px;
        cursor: pointer;
        height: 38px;
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #333;
        transition: all 0.3s ease;
        font-weight: 500;
        gap: 8px;
    }

    .filter-dropdown:hover {
        border-color: #1b5e20;
        background: #f5faf5;
    }

    .filter-menu {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        min-width: 220px;
        padding: 8px 0;
        animation: fadeInDown 0.25s ease;
    }

    .filter-menu.show {
        display: block;
    }

    .filter-option {
        padding: 10px 18px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 13px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #333;
        border-left: 3px solid transparent;
        min-height: 40px;
    }

    .filter-option:hover {
        background: #f1f8e9;
        border-left-color: #1b5e20;
    }

    /* === SUBMENU === */
    .submenu {
        display: none;
        position: absolute;
        left: 100%;
        top: -8px;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        min-width: 240px;
        max-width: 280px;
        z-index: 1001;
        overflow: hidden;
        animation: fadeInRight 0.25s ease;
    }

    .submenu.show {
        display: flex;
        flex-direction: column;
        max-height: 400px;
    }

    .submenu-search {
        padding: 8px 10px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafbfc;
        flex-shrink: 0;
    }

    .submenu-search-input {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 12px;
        outline: none;
        background: white;
    }

    .submenu-list {
        overflow-y: auto;
        max-height: 320px;
        padding: 4px 0;
    }

    .submenu-list::-webkit-scrollbar {
        width: 6px;
    }

    .submenu-list::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 4px;
    }

    .submenu .filter-option {
        padding: 8px 18px;
        font-size: 13px;
        min-height: 35px;
    }

    .submenu .filter-option.hidden {
        display: none;
    }

    .no-results-msg {
        padding: 12px 18px;
        text-align: center;
        color: #999;
        font-size: 12px;
        font-style: italic;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .filter-reset-btn {
        background: #f5f5f5 !important;
        color: #666 !important;
        border: 1px solid #ddd !important;
        padding: 6px 14px !important;
        height: 38px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
    }

    .filter-reset-btn:hover {
        background: #e53935 !important;
        color: white !important;
    }

    /* === Search Boxes === */
    .barcode-search-container,
    .search-container {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8f9fa;
        padding: 4px 12px 4px 4px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
    }

    .barcode-search-container input,
    .search-container input {
        border: none !important;
        background: transparent !important;
        padding: 8px 10px !important;
        height: 36px !important;
        font-size: 13px !important;
        outline: none !important;
    }

    .barcode-search-container input {
        width: 180px !important;
        font-family: monospace !important;
    }

    .search-container input {
        width: 250px !important;
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px dashed #d0d0d0;
        min-height: 36px;
        align-items: center;
    }

    .active-filters .filter-tag {
        background: #e8f5e9;
        color: #1b5e20;
        padding: 3px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #a5d6a7;
    }

    .active-filters .filter-tag .remove-tag {
        cursor: pointer;
        font-weight: 700;
        color: #666;
    }

    .active-filters .filter-tag .remove-tag:hover {
        color: #e53935;
    }

    .active-filters .no-filters {
        color: #999;
        font-size: 13px;
        font-style: italic;
    }

    /* === INVENTORY TABLE === */
    .table-responsive {
        overflow-x: auto;
        border-radius: 12px;
        background: white;
        border: 1px solid #f0f0f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    #inventoryTable {
        width: 100%;
        min-width: 800px;
        border-collapse: collapse;
        font-size: clamp(11px, 1.5vw, 13px);
    }

    #inventoryTable th {
        background: linear-gradient(180deg, #1b5e20, #2e7d32);
        color: white;
        font-weight: 600;
        font-size: clamp(10px, 1.2vw, 12px);
        padding: 14px 8px;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #inventoryTable td {
        padding: 11px 8px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    #inventoryTable tbody tr:hover {
        background-color: #f8fdf8 !important;
    }

    #inventoryTable tbody tr:nth-child(even) {
        background-color: #fafffa;
    }

    @if($isCashier)
    #inventoryTable th:last-child,
    #inventoryTable td:last-child {
        display: none !important;
    }
    @endif

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .action-btn-icon {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .edit-icon {
        background: #e3f2fd;
        color: #1565c0;
    }

    .edit-icon:hover {
        background: #1a73e8;
        color: white;
        transform: scale(1.1);
    }

    .delete-icon {
        background: #ffebee;
        color: #c62828;
    }

    .delete-icon:hover {
        background: #d32f2f;
        color: white;
        transform: scale(1.1);
    }

    .status-badge {
        font-size: clamp(10px, 1.2vw, 12px);
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid transparent;
    }

    .status-badge .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-available { background: #e8f5e9; color: #2e7d32; border-color: #a5d6a7; }
    .status-available .status-dot { background: #4caf50; }
    .status-lowstock { background: #fff3e0; color: #e65100; border-color: #ffcc80; }
    .status-lowstock .status-dot { background: #ff9800; }
    .status-expired { background: #ffebee; color: #c62828; border-color: #ef9a9a; }
    .status-expired .status-dot { background: #f44336; }
    .status-nearexpired { background: #fff8e1; color: #f57f17; border-color: #ffe082; }
    .status-nearexpired .status-dot { background: #ffc107; }
    .status-nearexpired-lowstock { background: #ffe0b2; color: #e65100; border-color: #ffab91; }
    .status-nearexpired-lowstock .status-dot { background: #ff6f00; }

    .form-badge, .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .badge-tablet { background: #e3f2fd; color: #0d47a1; border-color: #90caf9; }
    .badge-capsule { background: #f3e5f5; color: #4a148c; border-color: #ce93d8; }
    .badge-syrup { background: #e0f7fa; color: #00695c; border-color: #80deea; }
    .badge-drops { background: #e8eaf6; color: #283593; border-color: #9fa8da; }
    .badge-ointment { background: #fce4ec; color: #880e4f; border-color: #f48fb1; }
    .badge-injection { background: #e8f5e9; color: #1b5e20; border-color: #a5d6a7; }
    .badge-generic { background: #e8f5e9; color: #1b5e20; border-color: #a5d6a7; }
    .badge-branded { background: #e3f2fd; color: #0d47a1; border-color: #90caf9; }

    .classification-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        background: #e8f5e9;
        color: #2e7d32;
    }
    .classification-badge.otc { background: #e8f5e9; color: #2e7d32; }
    .classification-badge.prescription { background: #fff3e0; color: #e65100; }
    .classification-badge.dangerous { background: #ffebee; color: #c62828; }

    /* === PAGINATION === */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #fafbfc;
        border-top: 1px solid #e9ecef;
        flex-wrap: wrap;
        gap: 10px;
        border-radius: 0 0 12px 12px;
    }

    .pagination-info {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }

    .pagination-info strong {
        color: #1b5e20;
        font-weight: 700;
    }

    .pagination-links {
        display: flex;
        gap: 4px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination-links a,
    .pagination-links span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        background: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination-links a:hover {
        background: #e8f5e9;
        border-color: #1b5e20;
        color: #1b5e20;
        transform: translateY(-1px);
    }

    .pagination-links .active {
        background: #1b5e20;
        border-color: #1b5e20;
        color: white;
    }

    .pagination-links .disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-links .dots {
        border: none;
        background: transparent;
        color: #999;
        min-width: 20px;
        padding: 0 4px;
    }

    /* QUEUE TABLE */
    .queue-section {
        margin-top: 30px;
    }

    .queue-header {
        background: linear-gradient(135deg, #056b28, #0a8a3a);
        color: #fff;
        padding: 18px 25px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(5, 107, 40, 0.3);
    }

    .queue-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .queue-header p {
        margin: 5px 0 0;
        font-size: 13px;
        opacity: 0.9;
    }

    .queue-table-container {
        overflow-x: auto;
        border-radius: 12px;
        background: white;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #f0f0f0;
    }

    .queue-table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .queue-table th {
        background: linear-gradient(180deg, #1b5e20, #2e7d32);
        color: white;
        padding: 14px 8px;
        text-align: center;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    .queue-table td {
        padding: 10px 8px;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
    }

    .queue-transfer-btn {
        background: #1b5e20;
        color: white;
        padding: 6px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
    }

    .queue-transfer-btn:hover {
        background: #2e7d32;
    }

    .queue-remove-btn {
        background: #d32f2f;
        color: white;
        padding: 6px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        margin-left: 5px;
    }

    .queue-remove-btn:hover {
        background: #b71c1c;
    }

    /* === MODAL === */
    .modal {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px 35px;
        border-radius: 16px;
        width: 600px;
        max-width: 95%;
        max-height: 90vh;
        overflow-y: auto;
        z-index: 100000;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translate(-50%, -60%); }
        to { opacity: 1; transform: translate(-50%, -50%); }
    }

    .modal-content .close-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        cursor: pointer;
        background: none;
        border: none;
        color: #999;
        transition: all 0.3s ease;
    }

    .modal-content .close-modal:hover {
        color: #e53935;
        transform: rotate(90deg);
    }

    .modal-content h2 {
        color: #1b5e20;
        margin-bottom: 20px;
        font-size: 22px;
        font-weight: 700;
        border-left: 4px solid #1b5e20;
        padding-left: 15px;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 3px;
        display: block;
        font-size: 13px;
        color: #333;
    }

    .form-group label .required {
        color: #dc3545;
    }

    .form-group label .badge-auto {
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 9px;
        font-weight: 600;
        padding: 1px 8px;
        border-radius: 10px;
        margin-left: 6px;
        text-transform: uppercase;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border-radius: 6px;
        border: 2px solid #e9ecef;
        font-size: 13px;
        background: white;
        height: 38px;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #1b5e20;
        outline: none;
        box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.08);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .barcode-box {
        background: #f8f9fa;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
    }

    .barcode-wrapper {
        display: flex;
        gap: 8px;
    }

    .barcode-wrapper input {
        flex: 1;
        height: 36px;
        padding: 6px 10px;
        font-size: 12px;
        font-family: monospace;
    }

    .barcode-wrapper .btn-generate {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        height: 36px;
    }

    .barcode-wrapper .btn-generate:hover {
        background: #5a6268;
    }

    .text-muted-small {
        color: #6c757d;
        font-size: 11px;
        margin-top: 2px;
        display: block;
    }

    .image-preview {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        margin-top: 6px;
        border: 2px dashed #ccc;
        padding: 3px;
        background: white;
    }

    .unit-display {
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 6px;
        border: 2px solid #e9ecef;
        min-height: 36px;
        display: flex;
        align-items: center;
        font-size: 13px;
    }

    .unit-display .unit-value {
        font-weight: 700;
        color: #1b5e20;
        margin-left: 4px;
    }

    .unit-display .no-unit {
        color: #999;
        font-style: italic;
    }

    .stock-info-box {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        padding: 6px 12px;
        border-radius: 6px;
        text-align: center;
        border: 2px solid #1b5e20;
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #1b5e20;
        font-size: 14px;
    }

    .calculated-field {
        background: #e8f5e9 !important;
        border: 2px solid #1b5e20 !important;
        font-weight: 700;
        color: #1b5e20 !important;
    }

    .form-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 18px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .confirm-btn {
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
        color: white;
        padding: 10px 28px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
    }

    .confirm-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
    }

    .cancel-btn {
        background: #6c757d;
        color: white;
        padding: 10px 28px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
    }

    .cancel-btn:hover {
        background: #5a6268;
    }

    @media (max-width: 768px) {
        .modal-content {
            padding: 20px;
            width: 98%;
        }

        .form-row,
        .form-row-3 {
            grid-template-columns: 1fr;
        }

        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .toolbar-left {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container input,
        .barcode-search-container input {
            width: 100% !important;
        }

        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .pagination-links {
            justify-content: center;
        }

        .submenu {
            left: 0;
            top: 100%;
            max-width: 100%;
        }
    }

    .swal2-container { z-index: 999999 !important; }
    .swal2-popup { z-index: 999999 !important; }
</style>

<!-- Header -->
<div class="header-box">
    <h2>📦 Inventory Management</h2>
</div>

<!-- TABS -->
@if(!$isCashier)
<div class="inventory-tabs">
    <a href="{{ route('inventory.index', ['tab' => 'old-stock']) }}" class="tab {{ $tab == 'old-stock' ? 'active' : '' }}">
        <i class="fa-solid fa-boxes-stacked"></i> Old Stock
        <span class="badge-count">{{ $products->total() ?? 0 }}</span>
    </a>
    <a href="{{ route('inventory.index', ['tab' => 'new-stock']) }}" class="tab {{ $tab == 'new-stock' ? 'active' : '' }}">
        <i class="fa-solid fa-clock"></i> New Stock Queue 
        <span class="badge-count">{{ $queuedStocks->count() }}</span>
    </a>
</div>
@endif

<!-- ==================== OLD STOCK TAB ==================== -->
@if($tab == 'old-stock')

<!-- Toolbar -->
@if(!$isCashier)
<div class="toolbar">
    <div class="toolbar-left">
        <div class="filter-container">
            <label><i class="fa-solid fa-filter"></i></label>
            <div class="filter-dropdown" id="filterDropdown">
                <span class="filter-icon">📋</span>
                <span class="filter-text" id="filterDisplay">All Products</span>
                <span class="filter-arrow">▼</span>
            </div>
            
            <div class="filter-menu" id="filterMenu">
                <!-- Type -->
                <div class="filter-option has-submenu" data-filter="type">
                    <span><span class="option-icon">🏷️</span> Type</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu" data-submenu="type">
                        <div class="submenu-search">
                            <input type="text" class="submenu-search-input" placeholder="Search type..." data-target="type">
                        </div>
                        <div class="submenu-list" data-list="type">
                            <div class="filter-option" data-value="all" data-subfilter="type"><span>📋 All Types</span></div>
                            <div class="filter-option" data-value="Generic" data-subfilter="type"><span>🟢 Generic</span></div>
                            <div class="filter-option" data-value="Branded" data-subfilter="type"><span>🔵 Branded</span></div>
                        </div>
                    </div>
                </div>
                
                <!-- Form -->
                <div class="filter-option has-submenu" data-filter="form">
                    <span><span class="option-icon">💊</span> Form</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu" data-submenu="form">
                        <div class="submenu-search">
                            <input type="text" class="submenu-search-input" placeholder="Search form..." data-target="form">
                        </div>
                        <div class="submenu-list" data-list="form">
                            <div class="filter-option" data-value="all" data-subfilter="form"><span>📋 All Forms</span></div>
                            @foreach($dosageForms as $form)
                            <div class="filter-option" data-value="{{ $form->name }}" data-subfilter="form"><span>💊 {{ $form->name }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Drug Classification -->
                <div class="filter-option has-submenu" data-filter="drug_classification">
                    <span><span class="option-icon">📋</span> Drug Classification</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu" data-submenu="drug_classification">
                        <div class="submenu-search">
                            <input type="text" class="submenu-search-input" placeholder="Search classification..." data-target="drug_classification">
                        </div>
                        <div class="submenu-list" data-list="drug_classification">
                            <div class="filter-option" data-value="all" data-subfilter="drug_classification"><span>📋 All Classifications</span></div>
                            @foreach($drugClassifications as $classification)
                            <div class="filter-option" data-value="{{ $classification->name }}" data-subfilter="drug_classification"><span>📋 {{ $classification->name }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Status -->
                <div class="filter-option has-submenu" data-filter="status">
                    <span><span class="option-icon">📊</span> Status</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu" data-submenu="status">
                        <div class="submenu-search">
                            <input type="text" class="submenu-search-input" placeholder="Search status..." data-target="status">
                        </div>
                        <div class="submenu-list" data-list="status">
                            <div class="filter-option" data-value="all" data-subfilter="status"><span>📋 All Status</span></div>
                            <div class="filter-option" data-value="available" data-subfilter="status"><span>🟢 Available</span></div>
                            <div class="filter-option" data-value="lowstock" data-subfilter="status"><span>🟠 Low Stock</span></div>
                            <div class="filter-option" data-value="nearexpired" data-subfilter="status"><span>🟡 Near Expired</span></div>
                            <div class="filter-option" data-value="expired" data-subfilter="status"><span>🔴 Expired</span></div>
                        </div>
                    </div>
                </div>
                
                <!-- Category -->
                <div class="filter-option has-submenu" data-filter="category">
                    <span><span class="option-icon">📂</span> Category</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu" data-submenu="category">
                        <div class="submenu-search">
                            <input type="text" class="submenu-search-input" placeholder="Search category..." data-target="category">
                        </div>
                        <div class="submenu-list" data-list="category">
                            <div class="filter-option" data-value="all" data-subfilter="category"><span>📋 All Categories</span></div>
                            @foreach($categories as $category)
                            <div class="filter-option" data-value="{{ $category->name }}" data-subfilter="category"><span>📁 {{ $category->name }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="filter-reset-btn" id="resetFilters">
                <i class="fa-solid fa-rotate-right"></i> Reset
            </button>
        </div>
        
        <div class="barcode-search-container">
            <label>🔍</label>
            <input type="text" id="barcodeSearch" placeholder="Scan barcode...">
        </div>
        
        <div class="search-container">
            <label><i class="fa-solid fa-search"></i></label>
            <input type="text" id="searchBox" placeholder="Search product name..." autofocus>
        </div>
    </div>
    
    <div class="toolbar-right">
        <button id="addProductBtn">
            <i class="fa-solid fa-plus-circle"></i> Add Product
        </button>
    </div>
</div>

<div class="active-filters" id="activeFiltersDisplay">
    <span class="no-filters">No active filters</span>
</div>

@else
<div class="toolbar">
    <div class="toolbar-left">
        <div class="search-container">
            <label><i class="fa-solid fa-search"></i></label>
            <input type="text" id="searchBox" placeholder="Search product name...">
        </div>
    </div>
</div>
@endif

<!-- Old Stock Table -->
<div class="table-responsive">
    <table id="inventoryTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Barcode</th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Dosage</th>
                <th>Form</th>
                <th>Type</th>
                <th>Category</th>
                <th>Drug Classification</th>
                <th>Price</th>
                <th>Batch No.</th>
                <th>Total Boxes</th>
                <th>Pcs/Box</th>
                <th>Total Pcs</th>
                <th>Pcs Left</th>
                <th>Expiry Date</th>
                <th>Arrival Date</th>
                <th>Status</th>
                @if(!$isCashier)
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php $hasProducts = $products->isNotEmpty(); @endphp

            @if($hasProducts)
                @foreach($products as $product)
                    @php $hasBatch = $product->batches->isNotEmpty(); @endphp
                    
                    @if($hasBatch)
                        @foreach($product->batches as $batchIndex => $batch)
                        @php
                            $statusClass = $batch->status;
                            $statusText = $batch->status_text;
                            $form = $product->form ?? '';
                            $type = $product->type ?? '';
                            $drugClass = $product->drugClassification->name ?? 'N/A';
                            $drugClassType = $product->drugClassification->type ?? '';
                        @endphp
                        <tr id="batch-{{ $batch->id }}" class="batch-row" data-product-id="{{ $product->id }}">
                            @php
                                $globalIndex = $loop->parent->iteration + ($products->currentPage() - 1) * $products->perPage();
                            @endphp
                            <td>{{ $globalIndex }}</td>
                            <td>
                                @if($product->barcode)
                                    <span style="font-family: monospace; font-size: 11px; background: #f5f5f5; padding: 2px 8px; border-radius: 4px;">{{ $product->barcode }}</span>
                                @else
                                    <span style="color: #ccc;">—</span>
                                @endif
                            </td>
                            <td class="product-name-cell">{{ $product->name }}</td>
                            <td>{{ $product->brand ?? '-' }}</td>
                            <td>{{ $product->dosage_amount }} {{ $product->dosage_unit }}</td>
                            <td>
                                @if($form == 'Tablet') <span class="form-badge badge-tablet">Tablet</span>
                                @elseif($form == 'Capsule') <span class="form-badge badge-capsule">Capsule</span>
                                @elseif($form == 'Syrup') <span class="form-badge badge-syrup">Syrup</span>
                                @elseif($form == 'Drops') <span class="form-badge badge-drops">Drops</span>
                                @elseif($form == 'Ointment') <span class="form-badge badge-ointment">Ointment</span>
                                @elseif($form == 'Injection') <span class="form-badge badge-injection">Injection</span>
                                @else {{ $form }} @endif
                            </td>
                            <td>
                                @if($type == 'Generic') <span class="type-badge badge-generic">Generic</span>
                                @elseif($type == 'Branded') <span class="type-badge badge-branded">Branded</span>
                                @else {{ $type }} @endif
                            </td>
                            <td>{{ $product->category ?? '-' }}</td>
                            <td>
                                @if($drugClass != 'N/A')
                                    <span class="classification-badge {{ strtolower($drugClassType) }}">{{ $drugClass }}</span>
                                @else
                                    <span class="text-muted" style="font-size: 11px;">—</span>
                                @endif
                            </td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>Batch {{ $batchIndex + 1 }}</td>
                            <td>{{ $batch->quantity }}</td>
                            <td>{{ $batch->pieces_per_box }}</td>
                            <td>{{ $batch->total_pieces ?? ($batch->quantity * $batch->pieces_per_box) }}</td>
                            <td>{{ $batch->pieces_left }}</td>
                            <td>{{ \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($batch->arrival_date)->format('Y-m-d') }}</td>
                            <td>
                                <span class="status-badge status-{{ $statusClass }}">
                                    <span class="status-dot"></span>
                                    {{ $statusText }}
                                </span>
                            </td>
                            @if(!$isCashier)
                            <td class="action-buttons">
                                <button class="action-btn-icon edit-icon" 
                                        data-product-id="{{ $product->id }}" 
                                        data-batch-id="{{ $batch->id }}"
                                        title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                                <button class="action-btn-icon delete-icon" data-batch-id="{{ $batch->id }}" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                        <tr class="text-muted">
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->barcode)
                                    <span style="font-family: monospace; font-size: 11px; background: #f5f5f5; padding: 2px 8px; border-radius: 4px;">{{ $product->barcode }}</span>
                                @else
                                    <span style="color: #ccc;">—</span>
                                @endif
                            </td>
                            <td class="product-name-cell"><strong>{{ $product->name }}</strong></td>
                            <td>{{ $product->brand ?? '-' }}</td>
                            <td>{{ $product->dosage_amount }} {{ $product->dosage_unit }}</td>
                            <td>{{ $product->form ?? '-' }}</td>
                            <td>
                                @if($product->type == 'Generic') <span class="type-badge badge-generic">Generic</span>
                                @elseif($product->type == 'Branded') <span class="type-badge badge-branded">Branded</span>
                                @else {{ $product->type ?? '-' }} @endif
                            </td>
                            <td>{{ $product->category ?? '-' }}</td>
                            <td>
                                @php $drugClass = $product->drugClassification->name ?? 'N/A'; @endphp
                                @if($drugClass != 'N/A')
                                    <span class="classification-badge">{{ $drugClass }}</span>
                                @else
                                    <span class="text-muted" style="font-size: 11px;">—</span>
                                @endif
                            </td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td colspan="7" style="color: #999; font-style: italic;">No active batch</td>
                            <td><span class="status-badge status-expired">Out of Stock</span></td>
                            @if(!$isCashier)
                            <td class="action-buttons">
                                <button class="action-btn-icon edit-icon" 
                                        data-product-id="{{ $product->id }}" 
                                        data-batch-id=""
                                        title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="{{ $isCashier ? 18 : 19 }}" style="text-align: center; padding: 50px; color: #999;">
                        <i class="fa-solid fa-box-open" style="font-size: 48px; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
                        No products found. Start adding your inventory!
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div class="pagination-wrapper">
    <div class="pagination-info">
        Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> results
    </div>
    <div class="pagination-links">
        @if ($products->onFirstPage())
            <span class="disabled">‹</span>
        @else
            <a href="{{ $products->previousPageUrl() }}">‹</a>
        @endif

        @php
            $currentPage = $products->currentPage();
            $lastPage = $products->lastPage();
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
        @endphp

        @if($start > 1)
            <a href="{{ $products->url(1) }}">1</a>
            @if($start > 2)
                <span class="dots">…</span>
            @endif
        @endif

        @for($i = $start; $i <= $end; $i++)
            @if($i == $currentPage)
                <span class="active">{{ $i }}</span>
            @else
                <a href="{{ $products->url($i) }}">{{ $i }}</a>
            @endif
        @endfor

        @if($end < $lastPage)
            @if($end < $lastPage - 1)
                <span class="dots">…</span>
            @endif
            <a href="{{ $products->url($lastPage) }}">{{ $lastPage }}</a>
        @endif

        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}">›</a>
        @else
            <span class="disabled">›</span>
        @endif
    </div>
</div>
@endif

@endif

<!-- ==================== NEW STOCK QUEUE TAB ==================== -->
@if($tab == 'new-stock' && !$isCashier)

<div class="queue-section">
    <div class="queue-header">
        <h3><i class="fa-solid fa-clock"></i> New Stock Queue</h3>
        <p>Stock waiting for current inventory to run out</p>
    </div>

    @if($queuedStocks->isEmpty())
        <div style="text-align: center; padding: 60px; background: white; border-radius: 12px;">
            <i class="fa-solid fa-inbox" style="font-size: 48px; color: #ccc;"></i>
            <h3 style="margin-top: 15px;">No stock in queue</h3>
            <p style="color: #999;">All new stock has been transferred to inventory.</p>
        </div>
    @else
        <div class="queue-table-container">
            <table class="queue-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Dosage</th>
                        <th>Form</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Qty (Box)</th>
                        <th>Pcs/Box</th>
                        <th>Total Pcs</th>
                        <th>Expiry Date</th>
                        <th>Arrival Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queuedStocks as $stock)
                    @php
                        $currentProduct = $stock->product;
                    @endphp
                    <tr>
                        <td>{{ $currentProduct ? $currentProduct->id : 'New' }}</td>
                        <td>{{ $stock->product_name ?? ($currentProduct ? $currentProduct->name : 'N/A') }}</td>
                        <td>{{ $stock->brand ?? ($currentProduct ? $currentProduct->brand : 'N/A') }}</td>
                        <td>{{ $stock->dosage ?? ($currentProduct ? $currentProduct->dosage_amount . ' ' . $currentProduct->dosage_unit : '-') }}</td>
                        <td>
                            @php $form = $stock->form ?? ($currentProduct ? $currentProduct->form : ''); @endphp
                            @if($form == 'Tablet') <span class="form-badge badge-tablet">Tablet</span>
                            @elseif($form == 'Capsule') <span class="form-badge badge-capsule">Capsule</span>
                            @elseif($form == 'Syrup') <span class="form-badge badge-syrup">Syrup</span>
                            @elseif($form == 'Drops') <span class="form-badge badge-drops">Drops</span>
                            @elseif($form == 'Ointment') <span class="form-badge badge-ointment">Ointment</span>
                            @elseif($form == 'Injection') <span class="form-badge badge-injection">Injection</span>
                            @else {{ $form }} @endif
                        </td>
                        <td>
                            @php $type = $stock->type ?? ($currentProduct ? $currentProduct->type : ''); @endphp
                            @if($type == 'Generic') <span class="type-badge badge-generic">Generic</span>
                            @elseif($type == 'Branded') <span class="type-badge badge-branded">Branded</span>
                            @else {{ $type }} @endif
                        </td>
                        <td>{{ $stock->category ?? ($currentProduct ? $currentProduct->category : 'N/A') }}</td>
                        <td>₱{{ number_format($stock->price ?? ($currentProduct ? $currentProduct->price : 0), 2) }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{ $stock->pieces_per_box }}</td>
                        <td>{{ $stock->total_pieces ?? ($stock->quantity * $stock->pieces_per_box) }}</td>
                        <td>{{ $stock->expiry_date ? \Carbon\Carbon::parse($stock->expiry_date)->format('Y-m-d') : '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($stock->arrival_date)->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('stock-queue.transfer', $stock->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="queue-transfer-btn"><i class="fa-solid fa-arrow-right"></i> Transfer</button>
                            </form>
                            <form action="{{ route('stock-queue.destroy', $stock->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="queue-remove-btn" onclick="return confirm('Remove this queued stock?')"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endif

<!-- ============================================================ -->
<!-- === ADD/EDIT PRODUCT MODAL === -->
<!-- ============================================================ -->
@if(!$isCashier)
<div id="productModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" id="closeModalBtn">&times;</button>
        
        <h2 id="modalTitle"><i class="fas fa-boxes"></i> Add Product</h2>
        
        <form id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="productId">
            <input type="hidden" name="batch_id" id="batch_id">
            <input type="hidden" name="dosage_form_id" id="dosage_form_id">
            
            <div class="form-group">
                <label>Product Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" required placeholder="Enter product name...">
            </div>
            
            <div class="barcode-box">
                <div class="form-group">
                    <label>Barcode</label>
                    <div class="barcode-wrapper">
                        <input type="text" name="barcode" id="barcode" placeholder="Scan barcode..." style="font-family: monospace;">
                        <button type="button" id="generateBarcodeBtn" class="btn-generate">
                            <i class="fas fa-sync-alt"></i> Generate
                        </button>
                    </div>
                    <small class="text-muted-small">Leave blank to auto-generate</small>
                </div>
                <div id="barcodePreview" style="display: none; text-align: center; margin-top: 6px; padding: 6px; background: white; border-radius: 6px; border: 1px solid #e9ecef;">
                    <div id="previewImage"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" id="brand" placeholder="e.g., Unilab">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Dosage Amount <span class="required">*</span></label>
                    <input type="number" step="0.01" name="dosage_amount" id="dosage_amount" required placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Unit <span class="required">*</span></label>
                    <select name="dosage_unit" id="dosage_unit" required>
                        <option value="">Unit</option>
                        <option value="mg">mg</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="L">L</option>
                        <option value="IU">IU</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Form <span class="required">*</span> <span class="badge-auto">Auto Unit</span></label>
                <select name="form" id="form" required>
                    <option value="">Select Form</option>
                    @foreach($dosageForms as $dosageForm)
                        <option value="{{ $dosageForm->name }}" data-unit="{{ $dosageForm->abbreviation ?? '' }}">
                            {{ $dosageForm->name }}
                            @if($dosageForm->abbreviation)
                                ({{ $dosageForm->abbreviation }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group" id="unitDisplayGroup" style="display: none;">
                <div class="unit-display">
                    <i class="fas fa-check-circle" style="color: #1b5e20; font-size: 14px; margin-right: 6px;"></i>
                    <span>Auto-detected:</span>
                    <span class="unit-value" id="displayUnit">—</span>
                    <span class="no-unit" id="noUnitMessage" style="display: none;">No unit</span>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Type <span class="required">*</span></label>
                    <select name="type" id="type" required>
                        <option value="Generic">Generic</option>
                        <option value="Branded">Branded</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Category <span class="required">*</span></label>
                    <select name="category" id="category" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label>Drug Classification</label>
                <select name="drug_classification_id" id="drug_classification_id" class="form-select">
                    <option value="">None</option>
                    @foreach($drugClassifications as $classification)
                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted-small">Optional</small>
            </div>
            
            <div class="form-group">
                <label>Price (₱) <span class="required">*</span></label>
                <input type="number" name="price" id="price" step="0.01" required placeholder="0.00" min="0">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Qty (Boxes) <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" required min="1" value="1">
                </div>
                <div class="form-group">
                    <label>Pcs/Box <span class="required">*</span></label>
                    <input type="number" name="pieces_per_box" id="pieces_per_box" required min="1" value="10" placeholder="10">
                </div>
            </div>
            
            <div class="form-row-3">
                <div class="form-group">
                    <label>Pieces Left</label>
                    <input type="text" id="piecesLeft" class="calculated-field" readonly value="0">
                </div>
                <div class="form-group">
                    <label>Total Pieces</label>
                    <input type="text" id="totalPieces" class="calculated-field" readonly value="0">
                </div>
                <div class="form-group">
                    <label>Stock Status</label>
                    <div class="stock-info-box">
                        <span id="stockInfo">0 pcs</span>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date">
                    <small class="text-muted-small">Optional</small>
                </div>
                <div class="form-group">
                    <label>Arrival Date <span class="required">*</span></label>
                    <input type="date" name="arrival_date" id="arrival_date" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" id="imageInput" accept="image/*" style="height: 36px; padding: 4px 10px;">
                <img id="imagePreview" class="image-preview" style="display: none;">
                <small class="text-muted-small">Max 2MB. JPG, PNG.</small>
            </div>
            
            <div class="form-buttons">
                <button type="button" id="cancelModalBtn" class="cancel-btn">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="confirm-btn" id="submitProductBtn">
                    <i class="fas fa-save"></i> Save Product
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- ============================================================ -->
<!-- SCRIPTS -->
<!-- ============================================================ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

@if(!$isCashier)
let activeFilters = {
    type: 'all',
    form: 'all',
    status: 'all',
    category: 'all',
    drug_classification: 'all'
};

function calculatePieces() {
    let qty = parseInt($('#quantity').val()) || 0;
    let pcsPerBox = parseInt($('#pieces_per_box').val()) || 0;
    let total = qty * pcsPerBox;
    
    $('#totalPieces').val(total.toLocaleString());
    $('#piecesLeft').val(total.toLocaleString());
    $('#stockInfo').text(total.toLocaleString() + ' pcs');
    
    let stockInfo = $('#stockInfo');
    if (total === 0) { 
        stockInfo.css('color', '#dc3545'); 
    } else if (total < 100) { 
        stockInfo.css('color', '#f57c00'); 
    } else { 
        stockInfo.css('color', '#1b5e20'); 
    }
}

$(document).on('input', '#quantity, #pieces_per_box', function() {
    calculatePieces();
});

$(document).ready(function() {
    const formSelect = document.getElementById('form');
    const unitSelect = document.getElementById('dosage_unit');
    const displayGroup = document.getElementById('unitDisplayGroup');
    const displayUnit = document.getElementById('displayUnit');
    const noUnitMsg = document.getElementById('noUnitMessage');

    if (!formSelect) return;

    function autoDetectUnit() {
        const selectedOption = formSelect.options[formSelect.selectedIndex];
        const unit = selectedOption ? selectedOption.getAttribute('data-unit') : '';

        if (unit && unit.trim() !== '') {
            displayGroup.style.display = 'block';
            displayUnit.textContent = unit;
            displayUnit.style.display = 'inline';
            noUnitMsg.style.display = 'none';
            
            const options = unitSelect.options;
            let found = false;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === unit) {
                    unitSelect.value = unit;
                    found = true;
                    break;
                }
            }
            if (!found) {
                const opt = document.createElement('option');
                opt.value = unit;
                opt.textContent = unit;
                opt.selected = true;
                unitSelect.appendChild(opt);
            }
        } else {
            displayGroup.style.display = 'block';
            displayUnit.style.display = 'none';
            noUnitMsg.style.display = 'inline';
        }
    }

    formSelect.addEventListener('change', autoDetectUnit);
    if (formSelect.value) autoDetectUnit();
});

$(document).on('change', '#imageInput', function(e) {
    let file = e.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
});

function updateFilterDisplay() {
    let displayText = 'All Products';
    let hasFilter = false;
    let parts = [];
    
    if (activeFilters.type !== 'all') { hasFilter = true; parts.push(activeFilters.type); }
    if (activeFilters.form !== 'all') { hasFilter = true; parts.push(activeFilters.form); }
    if (activeFilters.status !== 'all') { hasFilter = true; parts.push(activeFilters.status); }
    if (activeFilters.category !== 'all') { hasFilter = true; parts.push(activeFilters.category); }
    if (activeFilters.drug_classification !== 'all') { hasFilter = true; parts.push(activeFilters.drug_classification); }
    
    if (hasFilter) displayText = 'Filtered: ' + parts.join(' • ');
    $('#filterDisplay').text(displayText);
    updateActiveFilterTags();
}

function updateActiveFilterTags() {
    let container = $('#activeFiltersDisplay');
    container.empty();
    let hasFilter = false;
    let filterMap = {
        type: { label: 'Type', value: activeFilters.type },
        form: { label: 'Form', value: activeFilters.form },
        status: { label: 'Status', value: activeFilters.status },
        category: { label: 'Category', value: activeFilters.category },
        drug_classification: { label: 'Classification', value: activeFilters.drug_classification }
    };
    
    Object.keys(filterMap).forEach(function(key) {
        if (filterMap[key].value !== 'all') {
            hasFilter = true;
            container.append(`<span class="filter-tag">${filterMap[key].label}: ${filterMap[key].value}<span class="remove-tag" data-filter="${key}">×</span></span>`);
        }
    });
    
    if (!hasFilter) container.html('<span class="no-filters">No active filters</span>');
}

$(document).on('click', '.remove-tag', function() {
    let filterKey = $(this).data('filter');
    activeFilters[filterKey] = 'all';
    updateFilterDisplay();
    applyFilters();
});

$('#resetFilters').click(function() {
    activeFilters = { type: 'all', form: 'all', status: 'all', category: 'all', drug_classification: 'all' };
    $('#filterDisplay').text('All Products');
    $('#filterMenu').removeClass('show');
    $('.submenu').removeClass('show');
    $('#filterDropdown').removeClass('active');
    updateFilterDisplay();
    applyFilters();
});

$('#filterDropdown').click(function(e) {
    e.stopPropagation();
    $(this).toggleClass('active');
    $('#filterMenu').toggleClass('show');
    $('.submenu').removeClass('show');
});

$('.filter-option.has-submenu').on('mouseenter', function(e) {
    $('.submenu').not($(this).find('.submenu')).removeClass('show');
    $(this).find('.submenu').addClass('show');
});

$('.submenu').on('mouseenter', function(e) {
    $(this).addClass('show');
}).on('mouseleave', function(e) {
    $(this).removeClass('show');
});

$('.submenu .filter-option').click(function(e) {
    e.stopPropagation();
    let value = $(this).data('value');
    let filterType = $(this).closest('.submenu').parent().data('filter');
    
    activeFilters[filterType] = value;
    updateFilterDisplay();
    
    $('#filterMenu').removeClass('show');
    $('.submenu').removeClass('show');
    $('#filterDropdown').removeClass('active');
    applyFilters();
});

$(document).click(function(e) {
    if (!$(e.target).closest('.filter-container').length) {
        $('#filterMenu').removeClass('show');
        $('.submenu').removeClass('show');
        $('#filterDropdown').removeClass('active');
    }
});

$(document).on('input', '.submenu-search-input', function() {
    const searchTerm = $(this).val().toLowerCase().trim();
    const target = $(this).data('target');
    const list = $(`.submenu-list[data-list="${target}"]`);
    
    list.find('.filter-option').each(function() {
        const text = $(this).text().toLowerCase();
        if (searchTerm === '' || text.includes(searchTerm)) {
            $(this).removeClass('hidden').show();
        } else {
            $(this).addClass('hidden').hide();
        }
    });
    
    const visibleCount = list.find('.filter-option:visible').length;
    let noResultMsg = list.find('.no-results-msg');
    
    if (visibleCount === 0 && searchTerm !== '') {
        if (noResultMsg.length === 0) {
            list.append(`<div class="no-results-msg"><i class="fas fa-search"></i> No results found</div>`);
        }
    } else {
        noResultMsg.remove();
    }
});

$(document).on('mouseleave', '.submenu', function() {
    $(this).find('.submenu-search-input').val('');
    $(this).find('.filter-option').removeClass('hidden').show();
    $(this).find('.no-results-msg').remove();
});

function applyFilters() {
    const searchTerm = $('#searchBox').val().toLowerCase().trim();
    
    $('#inventoryTable tbody tr').each(function() {
        let show = true;
        
        if ($(this).find('td').length === 1) return;
        
        if (searchTerm !== '') {
            const productName = $(this).find('td:eq(2)').text().toLowerCase().trim();
            if (!productName.includes(searchTerm)) show = false;
        }
        
        if (show && activeFilters.type !== 'all') {
            let type = $(this).find('td:eq(6)').text().trim();
            if (!type.includes(activeFilters.type)) show = false;
        }
        
        if (show && activeFilters.form !== 'all') {
            let form = $(this).find('td:eq(5) .form-badge').text().trim() || $(this).find('td:eq(5)').text().trim();
            if (!form.toLowerCase().includes(activeFilters.form.toLowerCase())) show = false;
        }
        
        if (show && activeFilters.status !== 'all') {
            let statusElem = $(this).find('.status-badge');
            let statusText = statusElem.text().trim().toLowerCase();
            let statusMatch = false;
            if (activeFilters.status === 'available' && statusText === 'available') statusMatch = true;
            else if (activeFilters.status === 'lowstock' && statusText.includes('low')) statusMatch = true;
            else if (activeFilters.status === 'nearexpired' && statusText.includes('near')) statusMatch = true;
            else if (activeFilters.status === 'expired' && statusText === 'expired') statusMatch = true;
            if (!statusMatch) show = false;
        }
        
        if (show && activeFilters.category !== 'all') {
            let category = $(this).find('td:eq(7)').text().trim();
            if (category !== activeFilters.category) show = false;
        }
        
        if (show && activeFilters.drug_classification !== 'all') {
            let drugClass = $(this).find('td:eq(8)').text().trim();
            let selectedClass = activeFilters.drug_classification;
            if (!drugClass.includes(selectedClass)) show = false;
        }
        
        $(this).toggle(show);
    });
}
@endif

$(document).on('input', '#searchBox', function() {
    const searchTerm = $(this).val().toLowerCase().trim();
    $('#inventoryTable tbody tr').each(function() {
        if ($(this).find('td').length === 1) return;
        const productName = $(this).find('td:eq(2)').text().toLowerCase().trim();
        $(this).toggle(productName.includes(searchTerm));
    });
});

@if(!$isCashier)
function openModal(title, action) {
    $('#modalTitle').text(title);
    $('#productForm').data('action', action);
    
    if (action === 'add') {
        $('#productId').val('');
        $('#batch_id').val('');
        $('#productForm')[0].reset();
        $('#imagePreview').hide();
        $('#barcodePreview').hide();
        $('#previewImage').empty();
        
        let today = new Date().toISOString().split('T')[0];
        $('#arrival_date').val(today);
        $('#quantity').val(1);
        $('#pieces_per_box').val(10);
    }
    
    $('#unitDisplayGroup').hide();
    $('#displayUnit').text('—').show();
    $('#noUnitMessage').hide();
    
    calculatePieces();
    
    let formSelect = document.getElementById('form');
    if (formSelect && formSelect.value) {
        formSelect.dispatchEvent(new Event('change'));
    }
    
    $('#productModal').show();
    $('body').css('overflow', 'hidden');
}

function closeModal() {
    $('#productModal').hide();
    $('body').css('overflow', '');
    $('#barcodePreview').hide();
    $('#previewImage').empty();
}

$('#addProductBtn').on('click', function(e) {
    e.preventDefault();
    openModal('Add Product', 'add');
});

$('#closeModalBtn').on('click', closeModal);
$('#cancelModalBtn').on('click', closeModal);

$(window).on('click', function(e) {
    if ($(e.target).is('#productModal')) closeModal();
});

$(document).on('click', '.edit-icon', function() {
    let productId = $(this).data('product-id');
    let batchId = $(this).data('batch-id');
    
    Swal.fire({ 
        title: 'Loading...', 
        allowOutsideClick: false, 
        didOpen: () => Swal.showLoading() 
    });
    
    $.ajax({
        url: `/inventory/${productId}/edit-data`,
        method: 'GET',
        success: function(response) {
            Swal.close();
            if (response.status === 'success') {
                let product = response.product;
                let batch = response.batch;
                
                $('#modalTitle').text('Edit Product');
                $('#productForm').data('action', 'edit');
                $('#productId').val(product.id);
                $('#batch_id').val(batch ? batch.id : '');
                $('#name').val(product.name);
                $('#barcode').val(product.barcode || '');
                $('#brand').val(product.brand || '');
                $('#dosage_amount').val(product.dosage_amount || '');
                $('#dosage_unit').val(product.dosage_unit || '');
                $('#form').val(product.form || '');
                $('#type').val(product.type || '');
                $('#category').val(product.category || '');
                $('#drug_classification_id').val(product.drug_classification_id || '');
                $('#price').val(product.price || '');
                
                if (batch) {
                    let qty = parseInt(batch.quantity) || 0;
                    let pcsPerBox = parseInt(batch.pieces_per_box) || 0;
                    let totalPieces = qty * pcsPerBox;
                    
                    $('#quantity').val(batch.quantity || 1);
                    $('#pieces_per_box').val(batch.pieces_per_box || 1);
                    $('#piecesLeft').val(batch.pieces_left !== undefined && batch.pieces_left !== null ? batch.pieces_left : totalPieces);
                    $('#totalPieces').val(totalPieces.toLocaleString());
                    $('#stockInfo').text(totalPieces.toLocaleString() + ' pcs');
                    
                    if (batch.expiry_date) $('#expiry_date').val(batch.expiry_date);
                    if (batch.arrival_date) $('#arrival_date').val(batch.arrival_date);
                } else {
                    $('#quantity').val(1);
                    $('#pieces_per_box').val(10);
                    $('#piecesLeft').val(0);
                    $('#totalPieces').val(0);
                    $('#stockInfo').text('0 pcs');
                }
                
                if (product.barcode) {
                    $('#previewImage').html(`<img src="/barcodes/image/${product.barcode}" style="height: 50px; border: 1px solid #ddd; padding: 5px; border-radius: 4px; background: white;">`);
                    $('#barcodePreview').show();
                } else {
                    $('#barcodePreview').hide();
                    $('#previewImage').empty();
                }
                
                if (product.image) {
                    $('#imagePreview').attr('src', '/storage/' + product.image).show();
                } else {
                    $('#imagePreview').hide();
                }
                
                setTimeout(function() {
                    let formSelect = document.getElementById('form');
                    if (formSelect && formSelect.value) {
                        formSelect.dispatchEvent(new Event('change'));
                    }
                }, 100);
                
                $('#productModal').show();
                $('body').css('overflow', 'hidden');
            }
        },
        error: function(xhr) { 
            Swal.close(); 
            Swal.fire('Error', 'Failed to load product data', 'error'); 
        }
    });
});

$(document).on('click', '.delete-icon', function() {
    let batchId = $(this).data('batch-id');
    Swal.fire({
        title: 'Delete Batch?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        confirmButtonText: 'Yes, delete'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/inventory/${batchId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    $(`#batch-${batchId}`).remove();
                    Swal.fire('Deleted!', 'Batch removed', 'success');
                } else {
                    Swal.fire('Error', data.message || 'Delete failed', 'error');
                }
            })
            .catch(() => Swal.fire('Error', 'Delete failed', 'error'));
        }
    });
});

let isSubmitting = false;

$('#productForm').on('submit', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    if (isSubmitting) return false;
    isSubmitting = true;
    
    let action = $(this).data('action');
    let formData = new FormData(this);
    let submitBtn = $('#submitProductBtn');
    
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    
    let url = action === 'edit' ? `/inventory/${$('#productId').val()}` : '/inventory';
    
    if (action === 'edit') formData.append('_method', 'PUT');
    
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
        timeout: 30000,
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: response.message, 
                    timer: 1500, 
                    showConfirmButton: false 
                }).then(() => { location.reload(); });
            } else {
                Swal.fire('Error', response.message || 'Operation failed', 'error');
                isSubmitting = false;
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Product');
            }
        },
        error: function(xhr) {
            let errorMsg = xhr.responseJSON?.message || 'Operation failed';
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                errorMsg = 'Validation errors:\n';
                Object.keys(xhr.responseJSON.errors).forEach(function(key) {
                    errorMsg += `- ${key}: ${xhr.responseJSON.errors[key].join(', ')}\n`;
                });
            }
            Swal.fire('Error', errorMsg, 'error');
            isSubmitting = false;
            submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Product');
        }
    });
});

$('#generateBarcodeBtn').on('click', function() {
    let btn = $(this);
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    
    $.ajax({
        url: '/barcodes/generate',
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Content-Type': 'application/json'
        },
        success: function(data) {
            if (data.barcode) {
                $('#barcode').val(data.barcode);
                $('#previewImage').html(`<img src="/barcodes/image/${data.barcode}" style="height: 50px; border: 1px solid #ddd; padding: 5px; border-radius: 4px; background: white;">`);
                $('#barcodePreview').show();
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Barcode Generated!', 
                    text: data.barcode, 
                    timer: 1500, 
                    showConfirmButton: false 
                });
            }
        },
        error: function() {
            Swal.fire({ 
                icon: 'error', 
                title: 'Generation Failed', 
                text: 'Could not generate barcode.' 
            });
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Generate');
        }
    });
});

$('#barcodeSearch').on('keypress', function(e) {
    if (e.key === 'Enter') {
        const barcode = $(this).val().trim();
        if (barcode) {
            Swal.fire({ 
                title: 'Searching...', 
                text: `Looking for barcode: ${barcode}`, 
                allowOutsideClick: false, 
                didOpen: () => Swal.showLoading() 
            });
            
            $.ajax({
                url: `/pos/find-by-barcode/${encodeURIComponent(barcode)}`,
                method: 'GET',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        const productId = response.product.id;
                        const productName = response.product.name;
                        const batchRow = $(`#inventoryTable tbody tr[data-product-id="${productId}"]`).first();
                        
                        if (batchRow.length) {
                            $('html, body').animate({ scrollTop: batchRow.offset().top - 100 }, 500);
                            batchRow.css('background', '#fff3cd');
                            setTimeout(() => { batchRow.css('background', ''); }, 3000);
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Product Found!', 
                                html: `<strong>${productName}</strong><br>Barcode: ${barcode}`, 
                                timer: 2000, 
                                showConfirmButton: false 
                            });
                        } else {
                            Swal.fire({ 
                                icon: 'warning', 
                                title: 'Product Exists But No Stock', 
                                html: `<strong>${productName}</strong><br>found but no active batch in inventory.` 
                            });
                        }
                    } else {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Barcode Not Found', 
                            text: `No product found with barcode: ${barcode}` 
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Search Failed', 
                        text: 'Could not connect to server.' 
                    });
                }
            });
            $(this).val('');
        }
    }
});
@endif

$(document).ready(function() {
    let today = new Date().toISOString().split('T')[0];
    $('#arrival_date').val(today);
    
    @if(!$isCashier)
    calculatePieces();
    updateFilterDisplay();
    @endif
    
    console.log('✅ Inventory page loaded successfully!');
});
</script>

@endsection