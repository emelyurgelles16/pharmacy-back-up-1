@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
    @if(auth()->user()->hasRole('Cashier'))
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

    .toolbar button:active {
        transform: translateY(0);
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

    .filter-container label {
        margin-right: 4px;
        color: #555;
        font-size: 13px;
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

    .filter-dropdown .filter-icon {
        font-size: 14px;
    }

    .filter-dropdown .filter-text {
        flex: 1;
    }

    .filter-dropdown .filter-arrow {
        font-size: 10px;
        color: #999;
        transition: transform 0.3s ease;
    }

    .filter-dropdown.active .filter-arrow {
        transform: rotate(180deg);
    }

    /* === FILTER MENU === */
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
        overflow: visible;
        animation: fadeInDown 0.25s ease;
    }

    .filter-menu.show {
        display: block;
    }

    /* === FILTER OPTION === */
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

    .filter-option .option-icon {
        margin-right: 10px;
        font-size: 14px;
    }

    .filter-option .submenu-arrow {
        font-size: 12px;
        color: #999;
        margin-left: 15px;
        transition: transform 0.3s ease;
    }

    .filter-option:hover .submenu-arrow {
        color: #1b5e20;
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
        min-width: 180px;
        padding: 8px 0;
        z-index: 1001;
        animation: fadeInRight 0.25s ease;
    }

    .submenu.show {
        display: block;
    }

    .submenu .filter-option {
        padding: 8px 18px;
        font-size: 13px;
        border-left: 3px solid transparent;
        min-height: 35px;
    }

    .submenu .filter-option:hover {
        background: #f1f8e9;
        border-left-color: #1b5e20;
    }

    .submenu .filter-option.active {
        background: #e8f5e9;
        border-left-color: #1b5e20;
        color: #1b5e20;
        font-weight: 600;
    }

    /* === ANIMATIONS === */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* === RESET BUTTON === */
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
        transition: all 0.3s ease !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        white-space: nowrap;
    }

    .filter-reset-btn:hover {
        background: #e53935 !important;
        color: white !important;
        border-color: #e53935 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
    }

    /* === Barcode Search === */
    .barcode-search-container {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8f9fa;
        padding: 4px 12px 4px 4px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
    }

    .barcode-search-container label {
        font-size: 13px;
        color: #555;
        padding-left: 8px;
    }

    .barcode-search-container input {
        border: none !important;
        background: transparent !important;
        padding: 8px 10px !important;
        height: 36px !important;
        width: 180px !important;
        font-family: monospace !important;
        font-size: 13px !important;
    }

    .barcode-search-container input:focus {
        box-shadow: none !important;
        border: none !important;
    }

    .barcode-search-container input::placeholder {
        color: #aaa;
        font-family: Arial, sans-serif;
    }

    /* === Search Box === */
    .search-container {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8f9fa;
        padding: 4px 12px 4px 4px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
    }

    .search-container label {
        font-size: 13px;
        color: #555;
        padding-left: 8px;
    }

    .search-container input {
        border: none !important;
        background: transparent !important;
        padding: 8px 10px !important;
        height: 36px !important;
        width: 180px !important;
    }

    .search-container input:focus {
        box-shadow: none !important;
        border: none !important;
    }

    .search-container input::placeholder {
        color: #aaa;
    }

    /* Active filter tags */
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
        transition: color 0.2s;
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
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
        border-radius: 12px;
        background: white;
        padding: 0;
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

    #inventoryTable tbody tr {
        transition: background 0.2s ease;
    }

    #inventoryTable tbody tr:hover {
        background-color: #f8fdf8 !important;
        box-shadow: inset 0 0 0 1px #c8e6c9;
    }

    #inventoryTable tbody tr:nth-child(even) {
        background-color: #fafffa;
    }

    /* ACTION BUTTONS - ICON ONLY */
    @if(auth()->user()->hasRole('Cashier'))
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
        text-decoration: none;
    }

    .edit-icon {
        background: #e3f2fd;
        color: #1565c0;
    }

    .edit-icon:hover {
        background: #1a73e8;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
    }

    .delete-icon {
        background: #ffebee;
        color: #c62828;
    }

    .delete-icon:hover {
        background: #d32f2f;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
    }

    /* STATUS BADGES */
    .status-badge {
        font-size: clamp(10px, 1.2vw, 12px);
        padding: 5px 14px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        letter-spacing: 0.3px;
        border: 1px solid transparent;
    }

    .status-badge .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(0.8); }
        100% { opacity: 1; transform: scale(1); }
    }

    .status-available { 
        background: #e8f5e9; 
        color: #2e7d32; 
        border-color: #a5d6a7;
    }
    .status-available .status-dot { background: #4caf50; }

    .status-lowstock { 
        background: #fff3e0; 
        color: #e65100; 
        border-color: #ffcc80;
    }
    .status-lowstock .status-dot { background: #ff9800; }

    .status-expired { 
        background: #ffebee; 
        color: #c62828; 
        border-color: #ef9a9a;
    }
    .status-expired .status-dot { background: #f44336; }

    .status-nearexpired { 
        background: #fff8e1; 
        color: #f57f17; 
        border-color: #ffe082;
    }
    .status-nearexpired .status-dot { background: #ffc107; }

    .status-nearexpired-lowstock { 
        background: #ffe0b2; 
        color: #e65100; 
        border-color: #ffab91;
    }
    .status-nearexpired-lowstock .status-dot { background: #ff6f00; }

    /* Form Badges */
    .form-badge, .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        border: 1px solid transparent;
    }

    .badge-tablet { 
        background: #e3f2fd; 
        color: #0d47a1; 
        border-color: #90caf9;
    }
    .badge-tablet::before { content: '💊'; font-size: 12px; }

    .badge-capsule { 
        background: #f3e5f5; 
        color: #4a148c; 
        border-color: #ce93d8;
    }
    .badge-capsule::before { content: '💊'; font-size: 12px; }

    .badge-syrup { 
        background: #e0f7fa; 
        color: #00695c; 
        border-color: #80deea;
    }
    .badge-syrup::before { content: '🧪'; font-size: 12px; }

    .badge-drops { 
        background: #e8eaf6; 
        color: #283593; 
        border-color: #9fa8da;
    }
    .badge-drops::before { content: '💧'; font-size: 12px; }

    .badge-ointment { 
        background: #fce4ec; 
        color: #880e4f; 
        border-color: #f48fb1;
    }
    .badge-ointment::before { content: '🧴'; font-size: 12px; }

    .badge-injection { 
        background: #e8f5e9; 
        color: #1b5e20; 
        border-color: #a5d6a7;
    }
    .badge-injection::before { content: '💉'; font-size: 12px; }

    .badge-generic { 
        background: #e8f5e9; 
        color: #1b5e20; 
        border-color: #a5d6a7;
    }
    .badge-generic::before { content: '🟢'; font-size: 10px; }

    .badge-branded { 
        background: #e3f2fd; 
        color: #0d47a1; 
        border-color: #90caf9;
    }
    .badge-branded::before { content: '🔵'; font-size: 10px; }

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
        letter-spacing: 0.5px;
    }

    .queue-table td {
        padding: 10px 8px;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .queue-table tbody tr:hover {
        background-color: #f8fdf8;
    }

    .queue-table tbody tr:nth-child(even) {
        background-color: #fafffa;
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
        transition: all 0.3s ease;
    }

    .queue-transfer-btn:hover {
        background: #2e7d32;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(27, 94, 32, 0.3);
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
        transition: all 0.3s ease;
    }

    .queue-remove-btn:hover {
        background: #b71c1c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
    }

    /* ============================================================ */
    /* === MODAL - OVERLAY WITH BLUR BACKGROUND === */
    /* ============================================================ */
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
        -webkit-backdrop-filter: blur(4px);
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
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
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
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
        line-height: 1;
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

    /* === FORM STYLES === */
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
        transition: all 0.3s ease;
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

    .form-group input[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
        border-color: #dee2e6;
        font-weight: 600;
        color: #1b5e20;
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

    .barcode-box {
        background: #f8f9fa;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #e9ecef;
    }

    .barcode-box .form-group {
        margin-bottom: 0;
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
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
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

    .barcode-preview {
        text-align: center;
        padding: 10px;
        background: white;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        margin-top: 8px;
    }

    .barcode-preview img {
        height: 50px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
        background: white;
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
        font-size: 13px !important;
        height: 38px !important;
        padding: 6px 10px !important;
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
        transition: all 0.3s ease;
    }

    .confirm-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
    }

    .confirm-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
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
        transition: all 0.3s ease;
    }

    .cancel-btn:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .modal-content {
            padding: 20px;
            width: 98%;
            max-height: 95vh;
        }

        .form-row,
        .form-row-3 {
            grid-template-columns: 1fr;
        }

        .barcode-wrapper {
            flex-direction: column;
        }

        .barcode-wrapper .btn-generate {
            width: 100%;
        }

        .form-buttons {
            flex-direction: column;
        }

        .form-buttons button {
            width: 100%;
        }

        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .toolbar-left {
            flex-direction: column;
            align-items: stretch;
        }

        .toolbar-right {
            justify-content: center;
        }

        .filter-container {
            flex-wrap: wrap;
        }

        .search-container input,
        .barcode-search-container input {
            width: 100% !important;
        }
    }

    .swal2-container {
        z-index: 999999 !important;
    }
    .swal2-popup {
        z-index: 999999 !important;
    }
</style>

<!-- Header -->
<div class="header-box">
    <h2>📦 Inventory Management</h2>
</div>

<!-- TABS -->
@if(!auth()->user()->hasRole('Cashier'))
<div class="inventory-tabs">
    <a href="{{ route('inventory.index', ['tab' => 'old-stock']) }}" class="tab {{ $tab == 'old-stock' ? 'active' : '' }}">
        <i class="fa-solid fa-boxes-stacked"></i> Old Stock
        <span class="badge-count">{{ $products->sum(fn($p) => $p->batches->count()) }}</span>
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
@if(!auth()->user()->hasRole('Cashier'))
<div class="toolbar">
    <div class="toolbar-left">
        <!-- Filter Container -->
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
                    <div class="submenu">
                        <div class="filter-option" data-value="all" data-subfilter="type">
                            <span>📋 All Types</span>
                        </div>
                        <div class="filter-option" data-value="Generic" data-subfilter="type">
                            <span>🟢 Generic</span>
                        </div>
                        <div class="filter-option" data-value="Branded" data-subfilter="type">
                            <span>🔵 Branded</span>
                        </div>
                    </div>
                </div>
                
                <!-- Form -->
                <div class="filter-option has-submenu" data-filter="form">
                    <span><span class="option-icon">💊</span> Form</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu">
                        <div class="filter-option" data-value="all" data-subfilter="form">
                            <span>📋 All Forms</span>
                        </div>
                        @foreach($dosageForms as $form)
                        <div class="filter-option" data-value="{{ $form->name }}" data-subfilter="form">
                            <span>💊 {{ $form->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Status -->
                <div class="filter-option has-submenu" data-filter="status">
                    <span><span class="option-icon">📊</span> Status</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu">
                        <div class="filter-option" data-value="all" data-subfilter="status">
                            <span>📋 All Status</span>
                        </div>
                        <div class="filter-option" data-value="available" data-subfilter="status">
                            <span>🟢 Available</span>
                        </div>
                        <div class="filter-option" data-value="lowstock" data-subfilter="status">
                            <span>🟠 Low Stock</span>
                        </div>
                        <div class="filter-option" data-value="nearexpired" data-subfilter="status">
                            <span>🟡 Near Expired</span>
                        </div>
                        <div class="filter-option" data-value="expired" data-subfilter="status">
                            <span>🔴 Expired</span>
                        </div>
                    </div>
                </div>
                
                <!-- Category -->
                <div class="filter-option has-submenu" data-filter="category">
                    <span><span class="option-icon">📂</span> Category</span>
                    <span class="submenu-arrow">▶</span>
                    <div class="submenu">
                        <div class="filter-option" data-value="all" data-subfilter="category">
                            <span>📋 All Categories</span>
                        </div>
                        @foreach($categories as $category)
                        <div class="filter-option" data-value="{{ $category->name }}" data-subfilter="category">
                            <span>📁 {{ $category->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Reset Filter Button -->
            <button class="filter-reset-btn" id="resetFilters">
                <i class="fa-solid fa-rotate-right"></i> Reset
            </button>
        </div>
        
        <!-- Barcode Search -->
        <div class="barcode-search-container">
            <label>🔍</label>
            <input type="text" id="barcodeSearch" placeholder="Scan barcode...">
        </div>
        
        <!-- Search Box -->
        <div class="search-container">
            <label><i class="fa-solid fa-search"></i></label>
            <input type="text" id="searchBox" placeholder="Search product...">
        </div>
    </div>
    
    <div class="toolbar-right">
        <button id="addProductBtn">
            <i class="fa-solid fa-plus-circle"></i> Add Product
        </button>
    </div>
</div>

<!-- Active Filters Display -->
<div class="active-filters" id="activeFiltersDisplay">
    <span class="no-filters">No active filters</span>
</div>

@else
<div class="toolbar">
    <div class="toolbar-left">
        <div class="search-container">
            <label><i class="fa-solid fa-search"></i></label>
            <input type="text" id="searchBox" placeholder="Search product...">
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
                <th>Price</th>
                <th>Batch No.</th>
                <th>Total Boxes</th>
                <th>Pcs/Box</th>
                <th>Total Pcs</th>
                <th>Pcs Left</th>
                <th>Expiry Date</th>
                <th>Arrival Date</th>
                <th>Status</th>
                @if(!auth()->user()->hasRole('Cashier'))
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                @foreach($product->batches as $batchIndex => $batch)
                @php
                    $statusClass = $batch->status;
                    $statusText = $batch->status_text;
                    $form = $product->form ?? '';
                    $type = $product->type ?? '';
                @endphp
                <tr id="batch-{{ $batch->id }}" class="batch-row" data-product-id="{{ $product->id }}">
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->barcode)
                            <span style="font-family: monospace; font-size: 11px; background: #f5f5f5; padding: 2px 8px; border-radius: 4px;">{{ $product->barcode }}</span>
                        @else
                            <span style="color: #ccc;">—</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
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
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>Batch {{ $batchIndex + 1 }}</td>
                    <td>{{ $batch->quantity }}</td>
                    <td>{{ $batch->pieces_per_box }}</td>
                    <td>{{ $batch->total_pieces }}</td>
                    <td>{{ $batch->pieces_left }}</td>
                    <td>{{ \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($batch->arrival_date)->format('Y-m-d') }}</td>
                    <td>
                        <span class="status-badge status-{{ $statusClass }}">
                            <span class="status-dot"></span>
                            {{ $statusText }}
                        </span>
                    </td>
                    @if(!auth()->user()->hasRole('Cashier'))
                    <td class="action-buttons">
                        <!-- ✅ EDIT BUTTON - MODAL (with data attributes) -->
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
            @empty
                <tr>
                    <td colspan="18" style="text-align: center; padding: 50px; color: #999;">
                        <i class="fa-solid fa-box-open" style="font-size: 48px; display: block; margin-bottom: 15px; opacity: 0.3;"></i>
                        No products found. Start adding your inventory!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endif

<!-- ==================== NEW STOCK QUEUE TAB ==================== -->
@if($tab == 'new-stock' && !auth()->user()->hasRole('Cashier'))

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
                        <th>ID</th><th>Product</th><th>Brand</th><th>Dosage</th><th>Form</th>
                        <th>Type</th><th>Category</th><th>Price</th><th>Qty (Box)</th>
                        <th>Pcs/Box</th><th>Total Pcs</th><th>Expiry Date</th>
                        <th>Arrival Date</th><th>Added By</th><th>Current Inventory</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($queuedStocks as $stock)
                    @php
                        $currentProduct = $stock->product;
                        $totalPiecesInInventory = $currentProduct ? $currentProduct->batches->sum('pieces_left') : 0;
                    @endphp
                    <tr>
                        <td>{{ $currentProduct ? $currentProduct->id : 'New' }}</td>
                        <td>{{ $stock->product_name ?? ($currentProduct ? $currentProduct->name : 'N/A') }}</td>
                        <td>{{ $stock->brand ?? ($currentProduct ? $currentProduct->brand : 'N/A') }}</td>
                        <td>{{ $stock->dosage_amount }} {{ $stock->dosage_unit }}</td>
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
                        <td>{{ $stock->quantity * $stock->pieces_per_box }}</td>
                        <td>{{ $stock->expiry_date ? \Carbon\Carbon::parse($stock->expiry_date)->format('Y-m-d') : '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($stock->arrival_date)->format('Y-m-d') }}</td>
                        <td>{{ $stock->addedByUser->username ?? 'N/A' }}</td>
                        <td>
                            <strong>{{ number_format($totalPiecesInInventory) }} pcs</strong>
                            @if($totalPiecesInInventory <= 0 && $currentProduct)
                                <span style="color: #e53935; font-size: 11px;"> (Empty!)</span>
                            @endif
                        </td>
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
<!-- === ADD/EDIT PRODUCT MODAL (WITH WORKING AUTO-DETECT) === -->
<!-- ============================================================ -->
@if(!auth()->user()->hasRole('Cashier'))
<div id="productModal" class="modal">
    <div class="modal-content">
        <button class="close-modal" id="closeModalBtn">&times;</button>
        
        <h2 id="modalTitle"><i class="fas fa-boxes"></i> Add Product</h2>
        
        <form id="productForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="productId">
            <input type="hidden" name="batch_id" id="batch_id">
            <input type="hidden" name="dosage_form_id" id="dosage_form_id">
            
            <!-- ===== PRODUCT NAME ===== -->
            <div class="form-group">
                <label>Product Name <span class="required">*</span></label>
                <input type="text" name="name" id="name" required placeholder="Enter product name...">
            </div>
            
            <!-- ===== BARCODE ===== -->
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
            
            <!-- ===== BRAND ===== -->
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" id="brand" placeholder="e.g., Unilab">
            </div>
            
            <!-- ===== DOSAGE ===== -->
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
            
            <!-- ===== FORM (with data-unit attribute) ===== -->
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
            
            <!-- ===== UNIT AUTO-DETECT ===== -->
            <div class="form-group" id="unitDisplayGroup" style="display: none;">
                <div class="unit-display">
                    <i class="fas fa-check-circle" style="color: #1b5e20; font-size: 14px; margin-right: 6px;"></i>
                    <span>Auto-detected:</span>
                    <span class="unit-value" id="displayUnit">—</span>
                    <span class="no-unit" id="noUnitMessage" style="display: none;">No unit</span>
                </div>
            </div>
            
            <!-- ===== TYPE & CATEGORY ===== -->
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
            
            <!-- ===== PRICE ===== -->
            <div class="form-group">
                <label>Price (₱) <span class="required">*</span></label>
                <input type="number" name="price" id="price" step="0.01" required placeholder="0.00" min="0">
            </div>
            
            <!-- ===== QUANTITY & PIECES PER BOX ===== -->
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
            
            <!-- ===== PIECES LEFT & TOTAL PIECES ===== -->
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
            
            <!-- ===== EXPIRY & ARRIVAL ===== -->
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
            
            <!-- ===== IMAGE ===== -->
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" id="imageInput" accept="image/*" style="height: 36px; padding: 4px 10px;">
                <img id="imagePreview" class="image-preview" style="display: none;">
                <small class="text-muted-small">Max 2MB. JPG, PNG.</small>
            </div>
            
            <!-- ===== BUTTONS ===== -->
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
// ============================================
// ACTIVE FILTERS
// ============================================
let activeFilters = {
    type: 'all',
    form: 'all',
    status: 'all',
    category: 'all'
};

// ============================================
// AUTO-CALCULATE PIECES
// ============================================
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

// ✅ I-attach ang event listeners - gamit ang $(document).on() para sa dynamic elements
$(document).on('input', '#quantity, #pieces_per_box', function() {
    calculatePieces();
});

// ============================================
// AUTO-DETECT UNIT FROM FORM
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const formSelect = document.getElementById('form');
    const unitSelect = document.getElementById('dosage_unit');
    const displayGroup = document.getElementById('unitDisplayGroup');
    const displayUnit = document.getElementById('displayUnit');
    const noUnitMsg = document.getElementById('noUnitMessage');

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

    // Initial trigger if form has value
    if (formSelect.value) {
        autoDetectUnit();
    }
});

// ============================================
// IMAGE PREVIEW
// ============================================
$('#imageInput').on('change', function(e) {
    let file = e.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
});

// ============================================
// FILTER FUNCTIONS
// ============================================
function updateFilterDisplay() {
    let displayText = 'All Products';
    let hasFilter = false;
    let parts = [];
    
    if (activeFilters.type !== 'all') { hasFilter = true; parts.push(activeFilters.type); }
    if (activeFilters.form !== 'all') { hasFilter = true; parts.push(activeFilters.form); }
    if (activeFilters.status !== 'all') { hasFilter = true; parts.push(activeFilters.status); }
    if (activeFilters.category !== 'all') { hasFilter = true; parts.push(activeFilters.category); }
    
    if (hasFilter) {
        displayText = 'Filtered: ' + parts.join(' • ');
    }
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
        category: { label: 'Category', value: activeFilters.category }
    };
    
    Object.keys(filterMap).forEach(function(key) {
        if (filterMap[key].value !== 'all') {
            hasFilter = true;
            let tag = $(`<span class="filter-tag">
                ${filterMap[key].label}: ${filterMap[key].value}
                <span class="remove-tag" data-filter="${key}">×</span>
            </span>`);
            container.append(tag);
        }
    });
    
    if (!hasFilter) {
        container.html('<span class="no-filters">No active filters</span>');
    }
}

$(document).on('click', '.remove-tag', function() {
    let filterKey = $(this).data('filter');
    activeFilters[filterKey] = 'all';
    updateFilterDisplay();
    applyFilters();
});

$('#resetFilters').click(function() {
    activeFilters = {
        type: 'all',
        form: 'all',
        status: 'all',
        category: 'all'
    };
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

function applyFilters() {
    $('#inventoryTable tbody tr').each(function() {
        let show = true;
        
        let type = $(this).find('td:eq(6)').text().trim();
        let form = $(this).find('td:eq(5) .form-badge').text().trim() || $(this).find('td:eq(5)').text().trim();
        let statusElem = $(this).find('.status-badge');
        let statusText = statusElem.text().trim().toLowerCase();
        let category = $(this).find('td:eq(7)').text().trim();

        if (activeFilters.type !== 'all' && !type.includes(activeFilters.type)) show = false;
        if (activeFilters.form !== 'all' && !form.toLowerCase().includes(activeFilters.form.toLowerCase())) show = false;
        if (activeFilters.status !== 'all') {
            let statusMatch = false;
            if (activeFilters.status === 'available' && statusText === 'available') statusMatch = true;
            else if (activeFilters.status === 'lowstock' && statusText.includes('low')) statusMatch = true;
            else if (activeFilters.status === 'nearexpired' && statusText.includes('near')) statusMatch = true;
            else if (activeFilters.status === 'expired' && statusText === 'expired') statusMatch = true;
            if (!statusMatch) show = false;
        }
        if (activeFilters.category !== 'all' && category !== activeFilters.category) show = false;
        
        let search = $('#searchBox').val().toLowerCase();
        let name = $(this).find('td:eq(2)').text().toLowerCase();
        if (search && !name.includes(search)) show = false;
        
        $(this).toggle(show);
    });
}

$('#searchBox').on('keyup', applyFilters);

// ============================================
// MODAL - OPEN / CLOSE (ADD & EDIT)
// ============================================
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
        
        // Set default arrival date
        let today = new Date().toISOString().split('T')[0];
        $('#arrival_date').val(today);
        $('#quantity').val(1);
        $('#pieces_per_box').val(10);
    }
    
    // Reset unit display
    $('#unitDisplayGroup').hide();
    $('#displayUnit').text('—').show();
    $('#noUnitMessage').hide();
    
    calculatePieces();
    
    // Trigger auto-detect if form has value
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

// Add Product Button
$('#addProductBtn').on('click', function(e) {
    e.preventDefault();
    openModal('Add Product', 'add');
});

// Close Modal - X button
$('#closeModalBtn').on('click', closeModal);

// Close Modal - Cancel button
$('#cancelModalBtn').on('click', closeModal);

// Close Modal - Click outside
$(window).on('click', function(e) {
    if ($(e.target).is('#productModal')) {
        closeModal();
    }
});

// ============================================
// EDIT BUTTON - LOAD DATA TO MODAL
// ============================================
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
                
                // Fill the modal form
                $('#modalTitle').text('Edit Product');
                $('#productForm').data('action', 'edit');
                $('#productId').val(product.id);
                $('#batch_id').val(batch.id);
                $('#name').val(product.name);
                $('#barcode').val(product.barcode || '');
                $('#brand').val(product.brand || '');
                $('#dosage_amount').val(product.dosage_amount || '');
                $('#dosage_unit').val(product.dosage_unit || '');
                $('#form').val(product.form || '');
                $('#type').val(product.type || '');
                $('#category').val(product.category || '');
                $('#price').val(product.price || '');
                $('#quantity').val(batch.quantity);
                $('#pieces_per_box').val(batch.pieces_per_box);
                $('#piecesLeft').val(batch.pieces_left);
                $('#totalPieces').val(batch.total_pieces);
                $('#stockInfo').text(batch.total_pieces.toLocaleString() + ' pcs');
                
                if (batch.expiry_date) $('#expiry_date').val(batch.expiry_date);
                if (batch.arrival_date) $('#arrival_date').val(batch.arrival_date);
                
                // Show barcode preview if exists
                if (product.barcode) {
                    $('#previewImage').html(`<img src="/barcodes/image/${product.barcode}" style="height: 50px; border: 1px solid #ddd; padding: 5px; border-radius: 4px; background: white;">`);
                    $('#barcodePreview').show();
                } else {
                    $('#barcodePreview').hide();
                    $('#previewImage').empty();
                }
                
                // Show image preview if exists
                if (product.image) {
                    $('#imagePreview').attr('src', '/storage/' + product.image).show();
                } else {
                    $('#imagePreview').hide();
                }
                
                // Trigger auto-detect after loading
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
            console.error('Error:', xhr);
            Swal.fire('Error', 'Failed to load product data', 'error'); 
        }
    });
});

// ============================================
// DELETE BUTTON
// ============================================
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
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
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

// ============================================
// FORM SUBMISSION (ADD & EDIT)
// ============================================
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
    
    if (action === 'edit') {
        formData.append('_method', 'PUT');
    }
    
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 1500, showConfirmButton: false })
                .then(() => { location.reload(); });
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

// ============================================
// BARCODE SEARCH
// ============================================
$('#barcodeSearch').on('keypress', function(e) {
    if (e.key === 'Enter') {
        const barcode = $(this).val().trim();
        if (barcode) {
            Swal.fire({ title: 'Searching...', text: `Looking for barcode: ${barcode}`, allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            
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
                            Swal.fire({ icon: 'success', title: 'Product Found!', html: `<strong>${productName}</strong><br>Barcode: ${barcode}`, timer: 2000, showConfirmButton: false });
                        } else {
                            Swal.fire({ icon: 'warning', title: 'Product Exists But No Stock', html: `<strong>${productName}</strong><br>found but no active batch in inventory.` });
                        }
                    } else {
                        Swal.fire({ icon: 'error', title: 'Barcode Not Found', text: `No product found with barcode: ${barcode}` });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({ icon: 'error', title: 'Search Failed', text: 'Could not connect to server.' });
                }
            });
            $(this).val('');
        }
    }
});

// ============================================
// BARCODE GENERATION
// ============================================
$('#generateBarcodeBtn').on('click', function() {
    let btn = $(this);
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    
    $.ajax({
        url: '/barcodes/generate',
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        success: function(data) {
            if (data.barcode) {
                $('#barcode').val(data.barcode);
                $('#previewImage').html(`<img src="/barcodes/image/${data.barcode}" style="height: 50px; border: 1px solid #ddd; padding: 5px; border-radius: 4px; background: white;">`);
                $('#barcodePreview').show();
                Swal.fire({ icon: 'success', title: 'Barcode Generated!', text: data.barcode, timer: 1500, showConfirmButton: false });
            }
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Generation Failed', text: 'Could not generate barcode.' });
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Generate');
        }
    });
});

// ============================================
// INITIALIZE
// ============================================
$(document).ready(function() {
    // Set default arrival date
    let today = new Date().toISOString().split('T')[0];
    $('#arrival_date').val(today);
    
    // Calculate initial pieces
    calculatePieces();
    
    // Update filter display
    updateFilterDisplay();
    
    console.log('✅ Inventory page loaded successfully!');
    console.log('✅ Edit button opens modal with product data');
});
</script>

@endsection