@extends('layouts.app')

@section('title', 'Point of Sale - Cashier')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - POS
       ============================================ */

    /* Full screen POS styles - OPTIMIZED FOR 1366x768 */
    .pos-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;
        background: #f4f8f2;
        overflow-y: auto;
        padding: 12px 18px;
    }
    
    .pos-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #1b5e20;
    }
    
    .back-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: 0.3s;
    }
    
    .back-btn:hover {
        background: #5a6268;
    }
    
    .pos-title {
        font-size: 20px;
        font-weight: 700;
        color: #1b5e20;
    }
    
    .pos-container {
        display: grid;
        grid-template-columns: 2.2fr 0.9fr;
        gap: 14px;
        align-items: start;
        height: calc(100vh - 100px);
        min-height: 500px;
    }
    
    /* ===== PRODUCTS PANEL - SCROLLABLE ===== */
    .products-panel {
        background: white;
        padding: 12px 14px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: calc(100vh - 130px);
        min-height: 400px;
    }
    
    /* ===== CART PANEL - EXTENDABLE ===== */
    .cart-panel {
        background: white;
        padding: 12px 14px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
        max-height: calc(100vh - 130px);
        min-height: 400px;
    }
    
    .controls {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }
    
    .search {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
        font-size: 13px;
        height: 32px;
    }
    
    .category-select {
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
        background: #fff;
        font-size: 13px;
        height: 32px;
    }
    
    /* ===== RESET BUTTON ===== */
    .reset-filter-btn {
        padding: 6px 14px;
        border-radius: 6px;
        border: none;
        background: #dc3545;
        color: white;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        height: 32px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .reset-filter-btn:hover {
        background: #c82333;
        transform: scale(1.02);
    }
    
    /* ===== PRODUCTS GRID - SCROLLABLE ===== */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 10px;
        overflow-y: auto;
        padding-right: 4px;
        flex: 1;
        min-height: 0;
        align-content: start;
    }
    
    .products-grid::-webkit-scrollbar {
        width: 6px;
    }
    
    .products-grid::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .products-grid::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 4px;
    }
    
    .products-grid::-webkit-scrollbar-thumb:hover {
        background: #2e7d32;
    }
    
    /* ===== PRODUCT CARD - UNIFORM HEIGHT ===== */
    .product-card {
        border-radius: 10px;
        padding: 8px 10px;
        text-align: center;
        border: 1px solid #eee;
        background: #fff;
        transition: all .15s;
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        height: 295px;
        min-height: 295px;
        max-height: 295px;
        position: relative;
        border-left-width: 4px;
        border-left-style: solid;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }
    
    /* Drug Classification Border Colors */
    .product-card.drug-otc { border-left-color: #22C55E; }
    .product-card.drug-prescription { border-left-color: #3B82F6; }
    .product-card.drug-controlled { border-left-color: #F59E0B; }
    .product-card.drug-dangerous { border-left-color: #EF4444; }
    .product-card.drug-none { border-left-color: #94a3b8; }
    
    .drug-badge {
        position: absolute;
        top: 6px;
        left: 6px;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: white;
        letter-spacing: 0.5px;
        z-index: 2;
    }
    .drug-badge.otc { background: #22C55E; }
    .drug-badge.prescription { background: #3B82F6; }
    .drug-badge.controlled { background: #F59E0B; }
    .drug-badge.dangerous { background: #EF4444; }
    .drug-badge.none { background: #94a3b8; }
    
    .product-image {
        width: 70px;
        height: 60px;
        object-fit: contain;
        background: #fafafa;
        border-radius: 6px;
        margin-bottom: 4px;
        margin-top: 8px;
        flex-shrink: 0;
    }
    
    .product-name {
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        margin-bottom: 2px;
        flex-shrink: 0;
        line-height: 1.2;
        min-height: 18px;
    }
    
    .product-brand {
        font-size: 11px;
        color: #666;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        flex-shrink: 0;
        line-height: 1.2;
        min-height: 16px;
    }
    
    .product-brand .brand-label {
        color: #999;
        font-size: 9px;
    }
    
    .product-type-badge {
        display: inline-block;
        padding: 1px 8px;
        border-radius: 10px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .product-type-badge.generic {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }
    
    .product-type-badge.branded {
        background: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #90caf9;
    }
    
    .product-type-badge.unknown {
        background: #f5f5f5;
        color: #999;
        border: 1px solid #ddd;
    }
    
    /* ===== PRICE SECTION - UNIFORM HEIGHT ===== */
    .product-price-section {
        width: 100%;
        min-height: 48px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin: 2px 0;
        padding: 2px 0;
    }
    
    .product-price {
        color: #1b5e20;
        font-weight: 700;
        font-size: 14px;
        line-height: 1.2;
    }
    
    .product-price-original {
        font-size: 10px;
        color: #999;
        text-decoration: line-through;
        line-height: 1.2;
        min-height: 12px;
    }
    
    .product-price-spacer {
        font-size: 10px;
        color: transparent;
        line-height: 1.2;
        min-height: 12px;
        user-select: none;
    }
    
    .product-stock {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
        flex-shrink: 0;
        min-height: 16px;
        line-height: 1.2;
    }
    
    /* ===== BOTTOM CONTROLS - FIXED AT BOTTOM ===== */
    .product-controls {
        margin-top: auto;
        width: 100%;
        flex-shrink: 0;
        padding-top: 4px;
    }
    
    .qty-controls {
        margin-top: 4px;
        display: flex;
        gap: 4px;
        align-items: center;
        justify-content: center;
    }
    
    .qty-btn {
        padding: 3px 8px;
        border-radius: 6px;
        border: none;
        background: #1b5e20;
        color: #fff;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
    }
    
    .qty-btn:hover:not(:disabled) {
        background: #2e7d32;
        transform: scale(1.05);
    }
    
    .qty-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    .qty-input {
        width: 40px;
        text-align: center;
        padding: 3px 4px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 13px;
        height: 28px;
    }
    
    /* ===== BADGES - ABSOLUTE POSITION ===== */
    .product-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        color: white;
        z-index: 2;
        letter-spacing: 0.3px;
    }
    
    .badge-promo { background: #9c27b0; }
    .badge-lowstock { background: #f57c00; }
    .badge-outofstock { background: #d32f2f; }
    
    /* ===== ADD BUTTON - FIXED AT BOTTOM ===== */
    .add-btn-container {
        margin-top: 4px;
        width: 100%;
    }
    
    .add-to-cart {
        width: 100%;
        background: #1b5e20;
        color: #fff;
        border-radius: 6px;
        font-size: 11px;
        padding: 5px 0;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
        height: 28px;
    }
    
    .add-to-cart:hover:not(:disabled) {
        background: #2e7d32;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(27, 94, 32, 0.3);
    }
    
    .add-to-cart:disabled {
        background: #ccc !important;
        cursor: not-allowed;
    }
    
    /* ===== CART PANEL - EXTENDABLE ===== */
    .cart-header {
        font-size: 16px;
        font-weight: 700;
        color: #1b5e20;
        margin-bottom: 6px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }
    
    /* ===== CART ITEMS - SCROLLABLE ===== */
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
        min-height: 0;
    }
    
    .cart-items::-webkit-scrollbar {
        width: 6px;
    }
    
    .cart-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .cart-items::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 4px;
    }
    
    .cart-items::-webkit-scrollbar-thumb:hover {
        background: #2e7d32;
    }
    
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 8px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .cart-left {
        display: flex;
        flex-direction: column;
        max-width: 70%;
    }
    
    .cart-name {
        font-weight: 600;
        font-size: 13px;
    }
    
    .cart-brand {
        font-size: 11px;
        color: #888;
    }
    
    .cart-meta {
        color: #666;
        font-size: 12px;
        margin-top: 2px;
    }
    
    .cart-actions {
        margin-top: 4px;
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }
    
    .btn-small {
        padding: 3px 8px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 12px;
    }
    
    .btn-remove {
        background: #e53935;
        color: #fff;
    }
    
    /* ===== SUMMARY - FIXED AT BOTTOM ===== */
    .summary {
        margin-top: 8px;
        border-top: 1px dashed #eee;
        padding-top: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex-shrink: 0;
        background: white;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        font-size: 13px;
        align-items: center;
        margin-bottom: 4px;
    }
    
    .payment-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-top: 1px dashed #eee;
        margin-top: 6px;
    }
    
    .payment-input {
        width: 100px;
        padding: 4px 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: right;
        font-weight: bold;
        font-size: 13px;
        height: 32px;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 8px;
        border-radius: 8px;
        border: none;
        background: #1b5e20;
        color: #fff;
        font-weight: 700;
        margin-top: 6px;
        font-size: 15px;
        flex-shrink: 0;
        cursor: pointer;
        transition: 0.3s;
    }
    
    .checkout-btn:hover:not(:disabled) {
        background: #2e7d32;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(27, 94, 32, 0.3);
    }
    
    .checkout-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    #customerTypeSelect {
        width: 150px;
        padding: 4px 28px 4px 10px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23474655' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        cursor: pointer;
        height: 32px;
    }
    
    #customerTypeSelect:hover {
        border-color: #1b5e20;
    }
    
    #customerTypeSelect:focus {
        outline: none;
        border-color: #1b5e20;
        box-shadow: 0 0 0 2px rgba(27, 94, 32, 0.1);
    }
    
    #idNumberInput {
        width: 150px;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid #cbd5e1;
        background-color: #ffffff;
        font-size: 13px;
        height: 32px;
    }
    
    #idNumberInput:focus {
        outline: none;
        border-color: #1b5e20;
        box-shadow: 0 0 0 2px rgba(27, 94, 32, 0.1);
    }
    
    @media (max-width: 1000px) {
        .pos-container {
            grid-template-columns: 1fr;
            height: auto;
            min-height: auto;
        }
        .products-panel {
            max-height: 500px;
            min-height: 300px;
        }
        .cart-panel {
            max-height: 500px;
            min-height: 300px;
        }
    }
    
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 10px 18px;
        border-radius: 8px;
        color: #fff;
        z-index: 2000;
        display: none;
        font-size: 13px;
    }
    
    #barcodeScanner {
        border: 2px solid #1b5e20;
        width: 220px;
        font-size: 13px;
        padding: 6px 10px;
        height: 32px;
    }
    
    #barcodeFeedback {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0,0,0,0.85);
        color: white;
        padding: 16px 32px;
        border-radius: 10px;
        font-size: 20px;
        font-weight: bold;
        z-index: 9999;
    }

    /* ===== CONFIRMATION MODAL ===== */
    .confirmation-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999999;
        align-items: center;
        justify-content: center;
    }
    
    .confirmation-modal.active {
        display: flex;
    }
    
    .confirmation-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }
    
    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .confirmation-content .modal-icon {
        text-align: center;
        font-size: 48px;
        color: #1b5e20;
        margin-bottom: 10px;
    }
    
    .confirmation-content h3 {
        text-align: center;
        color: #1b5e20;
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 20px;
    }
    
    .confirmation-content .summary-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    
    .confirmation-content .summary-item.total {
        font-weight: 700;
        font-size: 16px;
        color: #1b5e20;
        border-bottom: 2px solid #1b5e20;
        padding-top: 12px;
        margin-top: 4px;
    }
    
    .confirmation-content .summary-item .label {
        color: #666;
        font-size: 13px;
    }
    
    .confirmation-content .summary-item .value {
        font-weight: 600;
        font-size: 14px;
    }
    
    .confirmation-content .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .confirmation-content .btn-group button {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        font-size: 14px;
    }
    
    .btn-cancel-confirm {
        background: #e9ecef;
        color: #495057;
    }
    
    .btn-cancel-confirm:hover {
        background: #dee2e6;
    }
    
    .btn-confirm-payment {
        background: #1b5e20;
        color: white;
    }
    
    .btn-confirm-payment:hover {
        background: #0b7a33;
    }

    /* ===== RECEIPT PREVIEW ===== */
    .receipt-preview {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999999;
        align-items: center;
        justify-content: center;
    }
    
    .receipt-preview.active {
        display: flex;
    }
    
    .receipt-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        max-width: 450px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }
    
    .receipt-content .receipt-header {
        text-align: center;
        border-bottom: 2px dashed #ddd;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    
    .receipt-content .receipt-header h4 {
        font-weight: 700;
        color: #1b5e20;
        font-size: 18px;
    }
    
    .receipt-content .receipt-header small {
        color: #666;
        font-size: 12px;
    }
    
    .receipt-content .receipt-items {
        margin-bottom: 15px;
    }
    
    .receipt-content .receipt-item {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 13px;
        border-bottom: 1px dotted #f0f0f0;
    }
    
    .receipt-content .receipt-total {
        border-top: 2px solid #1b5e20;
        padding-top: 10px;
        margin-top: 5px;
    }
    
    .receipt-content .receipt-total .row {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
        font-size: 14px;
    }
    
    .receipt-content .receipt-total .row.grand-total {
        font-weight: 700;
        font-size: 16px;
        color: #1b5e20;
    }
    
    .receipt-content .btn-print {
        width: 100%;
        padding: 12px;
        background: #1b5e20;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 15px;
    }
    
    .receipt-content .btn-print:hover {
        background: #0b7a33;
        transform: translateY(-1px);
    }
    
    .receipt-content .btn-close-receipt {
        width: 100%;
        padding: 10px;
        background: #e9ecef;
        color: #495057;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 8px;
        transition: 0.2s;
        font-size: 14px;
    }
    
    .receipt-content .btn-close-receipt:hover {
        background: #dee2e6;
    }

    /* ===== PRESCRIPTION MODAL ===== */
    #prescriptionModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 16px 20px;
        border-radius: 10px;
        width: 450px;
        z-index: 999999;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    #prescriptionOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 999998;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .pos-container {
            grid-template-columns: 1fr;
            height: auto;
            min-height: auto;
        }
        .products-panel {
            max-height: 400px;
            min-height: 250px;
        }
        .cart-panel {
            max-height: 400px;
            min-height: 250px;
        }
        .controls {
            flex-direction: column;
            align-items: stretch;
        }
        .controls .search,
        .controls .category-select,
        .controls #barcodeScanner,
        .controls .reset-filter-btn {
            width: 100%;
        }
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        }
        .product-card {
            height: 275px;
            min-height: 275px;
            max-height: 275px;
        }
        #prescriptionModal {
            width: 95%;
        }
    }

    @media (max-width: 576px) {
        .pos-title {
            font-size: 16px;
        }
        .back-btn {
            font-size: 12px;
            padding: 4px 10px;
        }
        .product-card {
            height: 260px;
            min-height: 260px;
            max-height: 260px;
            padding: 6px 8px;
        }
        .product-name {
            font-size: 12px;
        }
        .product-price {
            font-size: 13px;
        }
        .qty-input {
            width: 32px;
            font-size: 12px;
        }
        .qty-btn {
            font-size: 11px;
            padding: 2px 6px;
        }
        .cart-name {
            font-size: 12px;
        }
        .summary-row {
            font-size: 12px;
        }
        .pos-container {
            gap: 10px;
        }
        .products-panel,
        .cart-panel {
            padding: 8px 10px;
        }
    }
</style>

<!-- ===== POS CONTENT ===== -->
<div class="pos-fullscreen">
    <div class="pos-header">
        <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
            <i class="fas fa-arrow-left me-2"></i> Back
        </button>
        <div class="pos-title">
            <i class="fas fa-cash-register me-2"></i> POS - Cashier
        </div>
        <div style="width: 80px;"></div>
    </div>
    
    <div class="pos-container">
        <!-- ===== PRODUCTS PANEL - SCROLLABLE ===== -->
        <div class="products-panel">
            <div class="controls">
                <!-- SEARCH -->
                <input id="search" class="search" placeholder="Search product..." style="width: 150;">
                
                <!-- BARCODE SCANNER -->
                <input type="text" id="barcodeScanner" class="search" 
                       placeholder="🔍 Scan barcode..." autofocus
                       style="width: 200px; border: 2px solid #1b5e20;">
                
                <!-- CATEGORY FILTER -->
                <select id="categoryFilter" class="category-select" style="width: 140px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <!-- DRUG CLASSIFICATION FILTER -->
                <select id="drugClassificationFilter" class="category-select" style="width: 140px; border-color: #1b5e20;">
                    <option value="">All Classifications</option>
                    @foreach($drugClassifications as $classification)
                        @php
                            $classType = strtolower($classification->type);
                            $icon = match($classType) {
                                'otc' => '🟢',
                                'prescription' => '🔵',
                                'controlled' => '🟠',
                                'dangerous' => '🔴',
                                default => '⚪'
                            };
                        @endphp
                        <option value="{{ $classType }}">{{ $icon }} {{ $classification->name }}</option>
                    @endforeach
                    <option value="none">⚪ Unclassified</option>
                </select>
                
                <!-- TYPE FILTER -->
                <select id="typeFilter" class="category-select" style="width: 120px; border-color: #1b5e20;">
                    <option value="">All Types</option>
                    <option value="generic">🟢 Generic</option>
                    <option value="branded">🔵 Branded</option>
                </select>
                
                <!-- RESET BUTTON -->
                <button class="reset-filter-btn" id="resetFiltersBtn">
                    <i class="fas fa-undo"></i> Reset
                </button>
                
                <!-- SOUND TOGGLE -->
                <button id="toggleScannerSound" class="qty-btn" style="background: #6c757d; padding: 4px 10px; font-size: 12px;">
                    <i class="fas fa-volume-up"></i>
                </button>
            </div>

            <div id="barcodeFeedback">✅ Product Added!</div>
            
            <div class="products-grid" id="productsGrid">
                @foreach($products as $p)
                @php
                    $expiryDate = $p->earliest_expiry ? \Carbon\Carbon::parse($p->earliest_expiry) : null;
                    $totalPiecesLeft = $p->total_pieces_left ?? 0;
                    $isExpired = $totalPiecesLeft == 0;
                    $isLowStock = $totalPiecesLeft <= 30 && $totalPiecesLeft > 0;
                    $hasPromo = $p->has_promo ?? false;
                    $promoDiscount = $p->promo_discount_percent ?? 0;
                    $discountedPrice = $p->discounted_price ?? $p->price;
                    
                    $categoryName = $p->category ?? 'uncategorized';
                    
                    $drugClass = $p->drugClassification;
                    $drugType = $drugClass ? strtolower($drugClass->type) : 'none';
                    $drugColor = $drugClass ? $drugClass->color : '#94a3b8';
                    $drugName = $drugClass ? $drugClass->name : 'Unclassified';
                    $requiresPrescription = $p->requires_prescription ?? false;
                    
                    $borderColor = '#94a3b8';
                    $badgeClass = 'none';
                    $badgeText = 'N/A';
                    
                    if ($drugClass) {
                        switch ($drugClass->type) {
                            case 'OTC':
                                $borderColor = '#22C55E';
                                $badgeClass = 'otc';
                                $badgeText = 'OTC';
                                break;
                            case 'Prescription':
                                $borderColor = '#3B82F6';
                                $badgeClass = 'prescription';
                                $badgeText = 'Rx';
                                break;
                            case 'Controlled':
                                $borderColor = '#F59E0B';
                                $badgeClass = 'controlled';
                                $badgeText = 'Controlled';
                                break;
                            case 'Dangerous':
                                $borderColor = '#EF4444';
                                $badgeClass = 'dangerous';
                                $badgeText = 'Dangerous';
                                break;
                            default:
                                $borderColor = '#94a3b8';
                                $badgeClass = 'none';
                                $badgeText = 'N/A';
                        }
                    }
                    
                    $typeClass = 'unknown';
                    $typeLabel = 'Unknown';
                    if ($p->type == 'Generic') {
                        $typeClass = 'generic';
                        $typeLabel = 'Generic';
                    } elseif ($p->type == 'Branded') {
                        $typeClass = 'branded';
                        $typeLabel = 'Branded';
                    }
                @endphp
                <div class="product-card drug-{{ $badgeClass }}"
                    data-id="{{ $p->id }}"
                    data-name="{{ $p->name }}"
                    data-brand="{{ $p->brand ?? 'No Brand' }}"
                    data-type="{{ strtolower($p->type ?? 'unknown') }}"
                    data-barcode="{{ $p->barcode }}"
                    data-price="{{ number_format($p->price, 2, '.', '') }}"
                    data-perbox="{{ $p->pieces_per_box ?? 1 }}"
                    data-pieces-left="{{ $totalPiecesLeft }}"
                    data-category="{{ strtolower($categoryName) }}"
                    data-expired="{{ $isExpired ? 'true' : 'false' }}"
                    data-has-promo="{{ $hasPromo ? 'true' : 'false' }}"
                    data-promo-percent="{{ $promoDiscount }}"
                    data-discounted-price="{{ number_format($discountedPrice, 2, '.', '') }}"
                    data-drug-class="{{ $drugType }}"
                    data-drug-name="{{ $drugName }}"
                    data-requires-prescription="{{ $requiresPrescription ? 'true' : 'false' }}"
                    style="border-left-color: {{ $borderColor }};">
                    
                    {{-- Drug Classification Badge --}}
                    <span class="drug-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                    
                    {{-- Stock/Promo Badge --}}
                    @if($isExpired)
                        <div class="product-badge badge-outofstock">OUT</div>
                    @elseif($hasPromo)
                        <div class="product-badge badge-promo">{{ $promoDiscount }}% OFF</div>
                    @elseif($isLowStock)
                        <div class="product-badge badge-lowstock">LOW</div>
                    @endif
                    
                    {{-- Product Image --}}
                    <img class="product-image" 
                         src="{{ $p->image ? asset('storage/'.$p->image) : asset('images/no-image.png') }}" 
                         alt="{{ $p->name }}">
                    
                    {{-- Product Name --}}
                    <div class="product-name" title="{{ $p->name }}">{{ $p->name }}</div>
                    
                    {{-- Product Brand --}}
                    <div class="product-brand" title="{{ $p->brand ?? 'No Brand' }}">
                        <span class="brand-label">Brand:</span> {{ $p->brand ?? 'No Brand' }}
                    </div>
                    
                    {{-- Product Type Badge --}}
                    <div style="margin-bottom: 2px; flex-shrink: 0;">
                        <span class="product-type-badge {{ $typeClass }}">{{ $typeLabel }}</span>
                    </div>
                    
                    {{-- Price Section (Uniform Height) --}}
                    <div class="product-price-section">
                        @if($hasPromo)
                            <div class="product-price">₱{{ number_format($discountedPrice, 2) }}</div>
                            <div class="product-price-original">₱{{ number_format($p->price, 2) }}</div>
                        @else
                            <div class="product-price">₱{{ number_format($p->price, 2) }}</div>
                            <div class="product-price-spacer">---</div>
                        @endif
                    </div>
                    
                    {{-- Stock Display --}}
                    <div class="product-stock">Stock: <span class="stock-display">{{ $totalPiecesLeft }}</span></div>
                    
                    {{-- Bottom Controls --}}
                    <div class="product-controls">
                        <div class="qty-controls">
                            <button class="qty-btn dec-qty" data-id="{{ $p->id }}" {{ $isExpired ? 'disabled' : '' }}>-</button>
                            <input class="qty-input" id="card-qty-{{ $p->id }}" type="number" value="1" min="1" {{ $isExpired ? 'disabled' : '' }}>
                            <button class="qty-btn inc-qty" data-id="{{ $p->id }}" {{ $isExpired ? 'disabled' : '' }}>+</button>
                        </div>
                        <div class="add-btn-container">
                            <button class="add-to-cart"
                                data-id="{{ $p->id }}"
                                {{ $isExpired ? 'disabled' : '' }}>
                                {{ $isExpired ? 'OUT OF STOCK' : 'ADD TO CART' }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach   
            </div>
        </div>

        <!-- ===== CART PANEL - EXTENDABLE ===== -->
        <div class="cart-panel">
            <div class="cart-header">
                <span><i class="fas fa-shopping-cart"></i> Cart</span>
                <button type="button" id="prescriptionBtn" class="qty-btn" style="background: #9c27b0; padding: 4px 10px; font-size: 12px;">
                    <i class="fas fa-prescription-bottle"></i> RX
                </button>
            </div>
            
            <div class="cart-items" id="cartItems">
                <div style="text-align:center;color:#777;padding:30px;font-size:13px;">Cart is empty</div>
            </div>
            
            <div class="summary">
                <div class="summary-row" style="font-size:14px;">
                    <strong>Subtotal</strong>
                    <strong>₱<span id="grandtotal">0.00</span></strong>
                </div>
                
                <div class="summary-row" style="margin-top:4px;">
                    <span><strong>Customer</strong></span>
                    <select id="customerTypeSelect">
                        <option value="">Regular</option>
                        @foreach($discountTypes as $discount)
                        <option value="{{ $discount->id }}" 
                                data-percent="{{ $discount->discount_percent }}"
                                data-requires-id="{{ $discount->requires_id ? 'true' : 'false' }}">
                            {{ $discount->name }} ({{ $discount->discount_percent }}%)
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="summary-row" id="idNumberRow" style="display: none; margin-top:4px;">
                    <span><strong>ID #</strong></span>
                    <input type="text" id="idNumberInput" placeholder="Enter ID number">
                </div>
                
                <div class="summary-row" style="margin-top:4px; border-top:1px solid #eee; padding-top:6px;">
                    <span>Discount</span>
                    <span id="discountAmountDisplay" style="color: #e53935; font-weight: bold;">-₱0.00</span>
                </div>
                
                <div class="summary-row" style="font-size:15px; color: #1b5e20; margin-top:4px;">
                    <strong>Total</strong>
                    <strong>₱<span id="finaltotal">0.00</span></strong>
                </div>
                
                <div class="payment-section">
                    <span style="font-size:13px;">Cash:</span>
                    <input type="number" id="cashInput" class="payment-input" value="0" min="0" step="0.01">
                </div>
                <div class="payment-section" style="padding-top:4px;">
                    <span style="font-size:13px;">Change:</span>
                    <span id="changeDisplay" style="font-weight: bold; color: #1b5e20; font-size:14px;">₱0.00</span>
                </div>
            </div>
            <button class="checkout-btn" id="checkoutBtn" disabled>Checkout</button>
        </div>
    </div>
</div>

<!-- ===== CONFIRMATION MODAL ===== -->
<div class="confirmation-modal" id="confirmationModal">
    <div class="confirmation-content">
        <div class="modal-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <h3>Confirm Payment</h3>
        
        <div id="confirmSummary">
            <div class="summary-item">
                <span class="label">Total Amount</span>
                <span class="value" id="confirmTotal">₱0.00</span>
            </div>
            <div class="summary-item">
                <span class="label">Amount Paid</span>
                <span class="value" id="confirmPaid">₱0.00</span>
            </div>
            <div class="summary-item">
                <span class="label">Change</span>
                <span class="value" id="confirmChange">₱0.00</span>
            </div>
            <div class="summary-item">
                <span class="label">Payment Method</span>
                <span class="value">Cash</span>
            </div>
            <div class="summary-item total">
                <span class="label">Total Due</span>
                <span class="value" id="confirmTotalDue">₱0.00</span>
            </div>
        </div>
        
        <div class="btn-group">
            <button class="btn-cancel-confirm" id="cancelConfirmBtn">Cancel</button>
            <button class="btn-confirm-payment" id="confirmPaymentBtn">
                <i class="fas fa-check me-1"></i> Confirm Payment
            </button>
        </div>
    </div>
</div>

<!-- ===== RECEIPT PREVIEW ===== -->
<div class="receipt-preview" id="receiptPreview">
    <div class="receipt-content">
        <div class="receipt-header">
            <h4><i class="fas fa-store me-2"></i> {{ \App\Models\Setting::get('pharmacy_name', 'AER Pharmacy') }}</h4>
            <small>{{ \App\Models\Setting::get('pharmacy_address', '') }}</small><br>
            <small>Tel: {{ \App\Models\Setting::get('pharmacy_contact', '') }}</small>
            <hr>
            <small><strong>Invoice:</strong> <span id="receiptInvoice">---</span></small><br>
            <small><strong>Date:</strong> <span id="receiptDate"></span></small>
            <small><strong>Cashier:</strong> {{ auth()->user()->full_name ?? auth()->user()->username }}</small>
            <hr style="border-top: 2px dashed #ddd;">
        </div>
        
        <div class="receipt-items" id="receiptItems"></div>
        
        <div class="receipt-total">
            <div class="row">
                <span>Subtotal</span>
                <span id="receiptSubtotal">₱0.00</span>
            </div>
            <div class="row">
                <span>Discount</span>
                <span id="receiptDiscount">₱0.00</span>
            </div>
            <div class="row grand-total">
                <span>Total</span>
                <span id="receiptTotal">₱0.00</span>
            </div>
            <div class="row">
                <span>Cash</span>
                <span id="receiptCash">₱0.00</span>
            </div>
            <div class="row">
                <span>Change</span>
                <span id="receiptChange">₱0.00</span>
            </div>
        </div>
        
        <button class="btn-print" id="printReceiptBtn">
            <i class="fas fa-print me-2"></i> Print Receipt
        </button>
        <button class="btn-close-receipt" id="closeReceiptBtn">Close</button>
    </div>
</div>

<!-- Prescription Modal -->
<div id="prescriptionModal">
    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
        <h4 style="color: #1b5e20; font-size:16px;"><i class="fas fa-prescription-bottle"></i> Search Prescription</h4>
        <button onclick="closePrescriptionModal()" style="background: none; border: none; font-size: 22px; cursor: pointer;">&times;</button>
    </div>
    <div style="display: flex; gap: 8px;">
        <input type="text" id="prescriptionSearch" placeholder="Patient name or RX #" style="flex: 1; padding: 6px 10px; border-radius: 6px; border: 1px solid #ddd; font-size:13px;">
        <button id="searchPrescriptionBtn" class="qty-btn" style="background: #1b5e20; padding:6px 14px; font-size:13px;">Search</button>
    </div>
    <div id="prescriptionResults" style="margin-top: 12px; max-height: 300px; overflow-y: auto; font-size:13px;"></div>
</div>

<div id="prescriptionOverlay"></div>

<!-- ===== JAVASCRIPT ===== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';
let products = {};
let cart = {};
let currentDiscountPercent = 0;
let currentRequiresId = false;
let currentDiscountTypeId = null;
let currentDiscountTypeName = '';
let scannerSoundEnabled = true;
let scanTimeout = null;
let activePrescription = null;
let lastSaleData = null;

// Initialize products data
document.querySelectorAll('.product-card').forEach(card => {
    const id = card.dataset.id;
    products[id] = {
        id: id,
        name: card.dataset.name,
        brand: card.dataset.brand || 'No Brand',
        type: card.dataset.type || 'unknown',
        barcode: card.dataset.barcode || null,
        price: parseFloat(card.dataset.price),
        perbox: parseInt(card.dataset.perbox) || 1,
        pieces_left: parseInt(card.dataset.piecesLeft) || 0,
        category: card.dataset.category || 'uncategorized',
        node: card,
        stockDisplay: card.querySelector('.stock-display'),
        hasPromo: card.dataset.hasPromo === 'true',
        promoPercent: parseInt(card.dataset.promoPercent) || 0,
        discountedPrice: parseFloat(card.dataset.discountedPrice) || parseFloat(card.dataset.price),
        originalPrice: parseFloat(card.dataset.price),
        drugClass: card.dataset.drugClass || 'none',
        drugName: card.dataset.drugName || 'Unclassified',
        requiresPrescription: card.dataset.requiresPrescription === 'true'
    };
});

function formatPeso(n) {
    return parseFloat(n || 0).toFixed(2);
}

function showNotification(msg, type = 'success') {
    let el = document.getElementById('notification');
    if (!el) {
        el = document.createElement('div');
        el.id = 'notification';
        el.className = 'notification';
        document.body.appendChild(el);
    }
    el.textContent = msg;
    el.style.display = 'block';
    el.style.background = type === 'error' ? '#e53935' : '#1b5e20';
    setTimeout(() => {
        el.style.opacity = '0';
        setTimeout(() => el.style.display = 'none', 250);
    }, 1800);
    el.style.opacity = '1';
}

function updateStockDisplay(productId, newStock) {
    if (!productId) return;
    const p = products[productId];
    if (!p) return;
    
    if (p.stockDisplay && p.stockDisplay.nodeType === 1) {
        p.stockDisplay.textContent = newStock;
    }
    p.pieces_left = newStock;
    
    const card = p.node || document.querySelector(`.product-card[data-id="${productId}"]`);
    if (card) {
        const addBtn = card.querySelector('.add-to-cart');
        if (addBtn) {
            if (newStock === 0) {
                addBtn.disabled = true;
                addBtn.textContent = 'OUT OF STOCK';
                addBtn.style.background = '#ccc';
                card.dataset.expired = 'true';
            } else {
                addBtn.disabled = false;
                addBtn.textContent = 'ADD TO CART';
                addBtn.style.background = '#1b5e20';
                card.dataset.expired = 'false';
            }
        }
        p.node = card;
    }
}

// Quantity controls
document.querySelectorAll('.dec-qty').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const id = this.dataset.id;
        const input = document.getElementById(`card-qty-${id}`);
        let val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    });
});

document.querySelectorAll('.inc-qty').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const id = this.dataset.id;
        const input = document.getElementById(`card-qty-${id}`);
        let val = parseInt(input.value) || 1;
        input.value = val + 1;
    });
});

// ==========================================
// ADD TO CART - WITH PRESCRIPTION CHECK
// ==========================================
document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const productId = this.dataset.id;
        const p = products[productId];
        
        if (!p) return;
        if (p.pieces_left === 0) {
            showNotification('Out of stock', 'error');
            return;
        }
        
        // ✅ CHECK 1: Kung prescription required at walang active prescription
        if (p.requiresPrescription && !activePrescription) {
            Swal.fire({
                icon: 'warning',
                title: '💊 Prescription Required',
                html: `
                    <div style="text-align: left; padding: 10px;">
                        <p style="font-size: 15px; margin-bottom: 10px;">
                            <strong style="color: #3B82F6;">${p.name}</strong> requires a prescription.
                        </p>
                        <p style="font-size: 14px; color: #666; margin-bottom: 10px;">
                            Classification: <strong>${p.drugName}</strong>
                        </p>
                        <hr style="margin: 10px 0;">
                        <p style="font-size: 14px; color: #666;">
                            Please add a prescription first by clicking the 
                            <strong style="color: #9c27b0;">RX</strong> button in the cart panel.
                        </p>
                    </div>
                `,
                confirmButtonColor: '#9c27b0',
                confirmButtonText: 'Open Prescription',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('prescriptionBtn').click();
                }
            });
            return;
        }
        
        // ✅ CHECK 2: Kung may active prescription, check kung nasa prescription ang product
        if (activePrescription && p.requiresPrescription) {
            let prescriptionItem = activePrescription.items.find(item => item.product_id == productId);
            if (!prescriptionItem) {
                Swal.fire({
                    icon: 'error',
                    title: '❌ Not in Prescription',
                    html: `
                        <div style="text-align: left; padding: 10px;">
                            <p style="font-size: 15px;">
                                <strong>${p.name}</strong> is not included in the active prescription.
                            </p>
                            <p style="font-size: 14px; color: #666;">
                                Patient: <strong>${activePrescription.patient_name}</strong><br>
                                RX #: <strong>${activePrescription.prescription_number}</strong>
                            </p>
                        </div>
                    `,
                    confirmButtonColor: '#d32f2f',
                    confirmButtonText: 'OK'
                });
                return;
            }
        }
        
        const qtyInput = document.getElementById(`card-qty-${productId}`);
        const qty = parseInt(qtyInput.value) || 1;
        
        if (qty > p.pieces_left) {
            showNotification(`Only ${p.pieces_left} left`, 'error');
            return;
        }
        
        // ✅ CHECK 3: Prescription quantity limit
        if (activePrescription && p.requiresPrescription) {
            let prescriptionItem = activePrescription.items.find(item => item.product_id == productId);
            if (prescriptionItem) {
                let existingQty = 0;
                if (cart[productId]) {
                    existingQty = cart[productId].qty;
                }
                let totalQty = existingQty + qty;
                
                if (totalQty > prescriptionItem.quantity_remaining) {
                    Swal.fire({
                        icon: 'warning',
                        title: '⚠️ Prescription Limit',
                        html: `
                            <p><strong>${p.name}</strong></p>
                            <p>Prescribed: <strong>${prescriptionItem.quantity_prescribed}</strong></p>
                            <p>Remaining: <strong>${prescriptionItem.quantity_remaining}</strong></p>
                            <p>In cart: <strong>${existingQty}</strong></p>
                            <hr>
                            <p style="color: #d32f2f;">Cannot add <strong>${qty}</strong> more. Only <strong>${prescriptionItem.quantity_remaining - existingQty}</strong> remaining.</p>
                        `,
                        confirmButtonColor: '#e65100',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }
        }
        
        const useDiscountedPrice = p.hasPromo;
        const unitPrice = useDiscountedPrice ? p.discountedPrice : p.price;
        const originalPrice = p.price;
        const totalBeforeDiscount = qty * unitPrice;
        const discountAmount = p.hasPromo ? (totalBeforeDiscount * p.promoPercent) / 100 : 0;
        const subtotal = totalBeforeDiscount - discountAmount;
        
        p.pieces_left -= qty;
        updateStockDisplay(productId, p.pieces_left);
        
        const key = `${productId}`;
        if (cart[key]) {
            cart[key].qty += qty;
            cart[key].subtotal = (cart[key].qty * cart[key].unitPrice) - 
                ((cart[key].qty * cart[key].unitPrice) * cart[key].discountPercent / 100);
        } else {
            cart[key] = {
                id: productId,
                name: p.name,
                brand: p.brand || 'No Brand',
                type: p.type || 'unknown',
                qty: qty,
                unitPrice: unitPrice,
                originalPrice: originalPrice,
                discountPercent: p.promoPercent,
                discountAmount: discountAmount,
                subtotal: subtotal,
                hasPromo: p.hasPromo,
                drugClass: p.drugClass,
                drugName: p.drugName,
                requiresPrescription: p.requiresPrescription
            };
        }
        
        updateCartDisplay();
        showNotification(`${qty}x ${p.name} added`);
    });
});

function updateCartDisplay() {
    const container = document.getElementById('cartItems');
    container.innerHTML = '';
    const keys = Object.keys(cart);
    
    if (keys.length === 0) {
        container.innerHTML = '<div style="text-align:center;color:#777;padding:25px;font-size:13px;">Cart is empty</div>';
        document.getElementById('checkoutBtn').disabled = true;
        updateDiscount();
        return;
    }
    
    keys.forEach((k) => {
        const item = cart[k];
        const row = document.createElement('div');
        row.className = 'cart-item';
        
        let badgeHtml = '';
        if (item.drugClass && item.drugClass !== 'none') {
            const drugColors = {
                'otc': '#22C55E',
                'prescription': '#3B82F6',
                'controlled': '#F59E0B',
                'dangerous': '#EF4444'
            };
            const color = drugColors[item.drugClass] || '#94a3b8';
            badgeHtml = `<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:${color};margin-right:4px;"></span>`;
        }
        
        row.innerHTML = `
            <div class="cart-left">
                <div class="cart-name">${badgeHtml} ${item.name}</div>
                <div class="cart-brand">${item.brand} (${item.type})</div>
                <div class="cart-meta">
                    ${item.qty} × ₱${formatPeso(item.unitPrice)}
                    ${item.hasPromo ? `<span style="color:#9c27b0;font-size:10px;"> 🔥${item.discountPercent}%</span>` : ''}
                </div>
                <div class="cart-actions">
                    <button class="btn-small btn-remove" onclick="removeCartItem('${k}')">Remove</button>
                </div>
            </div>
            <div style="font-weight:700;font-size:13px;">₱${formatPeso(item.subtotal)}</div>
        `;
        container.appendChild(row);
    });
    
    updateDiscount();
    document.getElementById('checkoutBtn').disabled = false;
}

function removeCartItem(key) {
    if (!cart[key]) return;
    const item = cart[key];
    const p = products[item.id];
    
    p.pieces_left += item.qty;
    updateStockDisplay(item.id, p.pieces_left);
    
    delete cart[key];
    updateCartDisplay();
}

function updateDiscount() {
    const subtotal = Object.values(cart).reduce((sum, item) => sum + item.subtotal, 0);
    const discountAmount = (subtotal * currentDiscountPercent) / 100;
    
    document.getElementById('discountAmountDisplay').innerHTML = `-₱${formatPeso(discountAmount)}`;
    
    const finalTotal = Math.max(0, subtotal - discountAmount);
    document.getElementById('grandtotal').textContent = formatPeso(subtotal);
    document.getElementById('finaltotal').textContent = formatPeso(finalTotal);
    
    calculatePayment();
}

function calculatePayment() {
    const subtotal = Object.values(cart).reduce((sum, item) => sum + item.subtotal, 0);
    const discountAmount = (subtotal * currentDiscountPercent) / 100;
    const finalTotal = Math.max(0, subtotal - discountAmount);
    const cashTendered = parseFloat(document.getElementById('cashInput').value) || 0;
    const change = cashTendered - finalTotal;
    document.getElementById('changeDisplay').innerHTML = `₱${formatPeso(change)}`;
}

// ==========================================
// FILTERS
// ==========================================
function applyFilters() {
    const searchTerm = document.getElementById('search').value.trim().toLowerCase();
    const categoryVal = document.getElementById('categoryFilter').value;
    const drugVal = document.getElementById('drugClassificationFilter').value;
    const typeVal = document.getElementById('typeFilter').value;
    
    let visibleCount = 0;
    
    document.querySelectorAll('.product-card').forEach(card => {
        const name = (card.dataset.name || '').toLowerCase();
        const brand = (card.dataset.brand || '').toLowerCase();
        const category = card.dataset.category || '';
        const drugClass = card.dataset.drugClass || '';
        const type = card.dataset.type || '';
        
        let show = true;
        
        if (searchTerm && !name.includes(searchTerm) && !brand.includes(searchTerm)) {
            show = false;
        }
        
        if (categoryVal && category !== categoryVal) {
            show = false;
        }
        
        if (drugVal && drugClass !== drugVal) {
            show = false;
        }
        
        if (typeVal && type !== typeVal) {
            show = false;
        }
        
        card.style.display = show ? 'flex' : 'none';
        if (show) visibleCount++;
    });
    
    let noResults = document.getElementById('noResultsMessage');
    if (visibleCount === 0) {
        if (!noResults) {
            noResults = document.createElement('div');
            noResults.id = 'noResultsMessage';
            noResults.style.cssText = 'grid-column: 1 / -1; text-align: center; padding: 40px; color: #999; font-size: 14px;';
            noResults.innerHTML = '<i class="fas fa-search" style="font-size: 24px; display: block; margin-bottom: 10px;"></i> No products match your filters';
            document.getElementById('productsGrid').appendChild(noResults);
        }
        noResults.style.display = 'block';
    } else {
        if (noResults) {
            noResults.style.display = 'none';
        }
    }
}

function resetFilters() {
    document.getElementById('search').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('drugClassificationFilter').value = '';
    document.getElementById('typeFilter').value = '';
    
    const noResults = document.getElementById('noResultsMessage');
    if (noResults) noResults.remove();
    
    applyFilters();
}

document.getElementById('search').addEventListener('input', applyFilters);
document.getElementById('categoryFilter').addEventListener('change', applyFilters);
document.getElementById('drugClassificationFilter').addEventListener('change', applyFilters);
document.getElementById('typeFilter').addEventListener('change', applyFilters);
document.getElementById('resetFiltersBtn').addEventListener('click', resetFilters);

// ==========================================
// BARCODE SCANNER
// ==========================================
const barcodeInput = document.getElementById('barcodeScanner');
const toggleSoundBtn = document.getElementById('toggleScannerSound');
const barcodeFeedback = document.getElementById('barcodeFeedback');

if (toggleSoundBtn) {
    toggleSoundBtn.addEventListener('click', function() {
        scannerSoundEnabled = !scannerSoundEnabled;
        this.innerHTML = scannerSoundEnabled ? '<i class="fas fa-volume-up"></i>' : '<i class="fas fa-volume-mute"></i>';
    });
}

function playBeep(type = 'success') {
    if (!scannerSoundEnabled) return;
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        oscillator.frequency.value = type === 'success' ? 880 : 440;
        oscillator.type = type === 'success' ? 'sine' : 'square';
        gainNode.gain.value = 0.2;
        oscillator.start();
        setTimeout(() => { oscillator.stop(); audioContext.close(); }, 150);
    } catch(e) {}
}

function showBarcodeFeedback(message, isError = false) {
    if (barcodeFeedback) {
        barcodeFeedback.textContent = isError ? `❌ ${message}` : `✅ ${message}`;
        barcodeFeedback.style.background = isError ? 'rgba(220, 53, 69, 0.9)' : 'rgba(27, 94, 32, 0.9)';
        barcodeFeedback.style.display = 'block';
        setTimeout(() => { barcodeFeedback.style.display = 'none'; }, 800);
    }
}

if (barcodeInput) {
    barcodeInput.addEventListener('input', function() {
        clearTimeout(scanTimeout);
        const barcode = this.value.trim();
        if (barcode.length >= 8) {
            scanTimeout = setTimeout(() => {
                let foundProduct = null;
                let foundProductId = null;
                for (const [id, product] of Object.entries(products)) {
                    if (product.barcode === barcode) {
                        foundProduct = product;
                        foundProductId = id;
                        break;
                    }
                }
                
                if (foundProduct && foundProduct.pieces_left > 0) {
                    if (foundProduct.requiresPrescription && !activePrescription) {
                        Swal.fire({
                            icon: 'warning',
                            title: '💊 Prescription Required',
                            html: `<strong>${foundProduct.name}</strong> requires a prescription. Please add a prescription first.`,
                            confirmButtonColor: '#9c27b0',
                            confirmButtonText: 'Open Prescription',
                            showCancelButton: true,
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('prescriptionBtn').click();
                            }
                        });
                        playBeep('error');
                        barcodeInput.value = '';
                        return;
                    }
                    
                    const qtyInput = document.getElementById(`card-qty-${foundProductId}`);
                    if (qtyInput) qtyInput.value = 1;
                    const addBtn = document.querySelector(`.add-to-cart[data-id="${foundProductId}"]`);
                    if (addBtn) { addBtn.click(); playBeep('success'); showBarcodeFeedback(`${foundProduct.name} added!`); }
                } else if (foundProduct && foundProduct.pieces_left === 0) {
                    playBeep('error');
                    showBarcodeFeedback('Out of stock!', true);
                } else {
                    playBeep('error');
                    showBarcodeFeedback('Not found!', true);
                }
                barcodeInput.value = '';
            }, 150);
        }
    });
    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); this.dispatchEvent(new Event('input')); }
    });
}

// ==========================================
// CUSTOMER DISCOUNT
// ==========================================
const customerTypeSelect = document.getElementById('customerTypeSelect');
const idNumberRow = document.getElementById('idNumberRow');
const idNumberInput = document.getElementById('idNumberInput');

customerTypeSelect.addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const discountPercent = parseFloat(selectedOption.getAttribute('data-percent') || 0);
    const requiresId = selectedOption.getAttribute('data-requires-id') === 'true';
    
    currentDiscountPercent = discountPercent;
    currentRequiresId = requiresId;
    currentDiscountTypeId = selectedOption.value || null;
    currentDiscountTypeName = selectedOption.textContent;
    
    if (requiresId && discountPercent > 0) {
        idNumberRow.style.display = 'flex';
    } else {
        idNumberRow.style.display = 'none';
        idNumberInput.value = '';
    }
    updateDiscount();
});

document.getElementById('cashInput').addEventListener('input', calculatePayment);

// ==========================================
// CHECKOUT
// ==========================================
document.getElementById('checkoutBtn').addEventListener('click', function() {
    const subtotal = Object.values(cart).reduce((sum, item) => sum + item.subtotal, 0);
    const discountAmount = (subtotal * currentDiscountPercent) / 100;
    const finalTotal = Math.max(0, subtotal - discountAmount);
    const cashTendered = parseFloat(document.getElementById('cashInput').value) || 0;
    
    if (currentRequiresId && currentDiscountPercent > 0) {
        const idNumber = idNumberInput.value.trim();
        if (!idNumber) {
            showNotification('Please enter ID number', 'error');
            return;
        }
    }
    
    const prescriptionItems = Object.values(cart).filter(item => item.requiresPrescription);
    if (prescriptionItems.length > 0 && !activePrescription) {
        Swal.fire({
            icon: 'error',
            title: '❌ Prescription Required',
            html: `
                <p>The following items require a prescription:</p>
                <ul style="text-align: left; margin: 10px 0;">
                    ${prescriptionItems.map(item => `<li><strong>${item.name}</strong></li>`).join('')}
                </ul>
                <p>Please add a prescription first.</p>
            `,
            confirmButtonColor: '#9c27b0',
            confirmButtonText: 'Open Prescription',
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('prescriptionBtn').click();
            }
        });
        return;
    }
    
    if (cashTendered < finalTotal) {
        showNotification('Need ₱' + formatPeso(finalTotal - cashTendered) + ' more', 'error');
        return;
    }
    
    document.getElementById('confirmTotal').textContent = '₱' + formatPeso(finalTotal);
    document.getElementById('confirmPaid').textContent = '₱' + formatPeso(cashTendered);
    document.getElementById('confirmChange').textContent = '₱' + formatPeso(cashTendered - finalTotal);
    document.getElementById('confirmTotalDue').textContent = '₱' + formatPeso(finalTotal);
    
    document.getElementById('confirmationModal').classList.add('active');
});

document.getElementById('cancelConfirmBtn').addEventListener('click', function() {
    document.getElementById('confirmationModal').classList.remove('active');
});

document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
    processPayment();
});

function processPayment() {
    const subtotal = Object.values(cart).reduce((sum, item) => sum + item.subtotal, 0);
    const discountAmount = (subtotal * currentDiscountPercent) / 100;
    const finalTotal = Math.max(0, subtotal - discountAmount);
    const cashTendered = parseFloat(document.getElementById('cashInput').value) || 0;
    
    const cartArray = Object.values(cart).map(item => ({
        id: item.id,
        type: 'piece',
        qty: item.qty,
        unitPrice: item.unitPrice,
        originalPrice: item.originalPrice,
        discountPercent: item.discountPercent,
        discountAmount: item.discountAmount,
        subtotal: item.subtotal,
        piecesPerBox: 1,
        hasPromo: item.hasPromo,
        brand: item.brand,
        typeLabel: item.type
    }));
    
    const requestData = {
        cart_items: cartArray,
        discount: discountAmount,
        discount_percent: currentDiscountPercent,
        discount_type_id: currentDiscountTypeId,
        cash_tendered: cashTendered,
        prescription_id: activePrescription ? activePrescription.id : null
    };
    
    if (currentRequiresId && currentDiscountPercent > 0) {
        requestData.id_number = idNumberInput.value.trim();
        requestData.customer_type_name = currentDiscountTypeName;
    }
    
    document.getElementById('confirmationModal').classList.remove('active');
    
    Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we process your payment.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    fetch('{{ route('pos.checkout') }}', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': CSRF_TOKEN, 
            'Accept': 'application/json' 
        },
        body: JSON.stringify(requestData)
    })
    .then(res => res.json())
    .then(data => {
        Swal.close();
        
        if (data.success) {
            lastSaleData = data;
            showReceiptPreview(data);
        } else {
            Swal.fire({ 
                title: '❌ Failed', 
                text: data.message || 'Transaction failed. Please try again.', 
                icon: 'error', 
                confirmButtonText: 'OK' 
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Checkout error:', error);
        Swal.fire({ 
            title: '❌ Error', 
            text: 'Something went wrong. Please try again.', 
            icon: 'error', 
            confirmButtonText: 'OK' 
        });
    });
}

// ==========================================
// RECEIPT PREVIEW
// ==========================================
function showReceiptPreview(data) {
    const now = new Date();
    
    document.getElementById('receiptInvoice').textContent = data.invoice_no;
    document.getElementById('receiptDate').textContent = now.toLocaleString();
    
    let itemsHtml = '';
    Object.values(cart).forEach(item => {
        let badgeHtml = '';
        if (item.drugClass && item.drugClass !== 'none') {
            const drugColors = {
                'otc': '#22C55E',
                'prescription': '#3B82F6',
                'controlled': '#F59E0B',
                'dangerous': '#EF4444'
            };
            const color = drugColors[item.drugClass] || '#94a3b8';
            badgeHtml = `<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:${color};margin-right:6px;"></span>`;
        }
        itemsHtml += `
            <div class="receipt-item">
                <span>${badgeHtml} ${item.qty}x ${item.name}</span>
                <span>₱${formatPeso(item.subtotal)}</span>
            </div>
        `;
    });
    document.getElementById('receiptItems').innerHTML = itemsHtml;
    
    const subtotal = Object.values(cart).reduce((sum, item) => sum + item.subtotal, 0);
    const discountAmount = (subtotal * currentDiscountPercent) / 100;
    const finalTotal = Math.max(0, subtotal - discountAmount);
    const cashTendered = parseFloat(document.getElementById('cashInput').value) || 0;
    
    document.getElementById('receiptSubtotal').textContent = '₱' + formatPeso(subtotal);
    document.getElementById('receiptDiscount').textContent = '₱' + formatPeso(discountAmount);
    document.getElementById('receiptTotal').textContent = '₱' + formatPeso(finalTotal);
    document.getElementById('receiptCash').textContent = '₱' + formatPeso(cashTendered);
    document.getElementById('receiptChange').textContent = '₱' + formatPeso(cashTendered - finalTotal);
    
    document.getElementById('receiptPreview').classList.add('active');
}

document.getElementById('printReceiptBtn').addEventListener('click', function() {
    const printWindow = window.open('{{ url("/") }}/receipts/' + lastSaleData.sale_id + '/print', '_blank', 'width=400,height=600');
    
    if (printWindow) {
        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.focus();
                printWindow.print();
            }, 500);
        };
    } else {
        window.open('{{ url("/") }}/receipts/' + lastSaleData.sale_id + '/print', '_blank');
    }
});

document.getElementById('closeReceiptBtn').addEventListener('click', function() {
    document.getElementById('receiptPreview').classList.remove('active');
    cart = {};
    activePrescription = null;
    updateCartDisplay();
    window.location.reload();
});

// ==========================================
// PRESCRIPTION FUNCTIONS
// ==========================================
function closePrescriptionModal() {
    document.getElementById('prescriptionModal').style.display = 'none';
    document.getElementById('prescriptionOverlay').style.display = 'none';
}

document.getElementById('prescriptionBtn').addEventListener('click', function() {
    document.getElementById('prescriptionModal').style.display = 'block';
    document.getElementById('prescriptionOverlay').style.display = 'block';
    document.getElementById('prescriptionSearch').focus();
});

document.getElementById('searchPrescriptionBtn').addEventListener('click', function() {
    let searchTerm = document.getElementById('prescriptionSearch').value.trim();
    if (!searchTerm) {
        Swal.fire('Error', 'Please enter patient name or RX number', 'error');
        return;
    }
    document.getElementById('prescriptionResults').innerHTML = '<div style="text-align:center;padding:20px;"><i class="fas fa-spinner fa-pulse"></i> Searching...</div>';
    fetch(`/pos/search-prescription?search=${encodeURIComponent(searchTerm)}`, {
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            let html = '';
            data.data.forEach(function(p) {
                let itemsHtml = '';
                p.items.forEach(function(item) {
                    let remaining = item.quantity_remaining;
                    itemsHtml += `<div style="padding:4px 0;border-bottom:1px solid #eee;font-size:12px;">
                        <strong>${item.product_name}</strong> — Remaining: <strong style="color:${remaining > 0 ? '#2e7d32' : '#d32f2f'}">${remaining}</strong>
                    </div>`;
                });
                html += `<div onclick="loadPrescription(${p.id}, '${p.prescription_number}')" style="border:1px solid #ddd;border-radius:6px;padding:10px;margin-bottom:8px;cursor:pointer;">
                    <strong style="color:#1b5e20;">${p.patient_name}</strong>
                    <small> | RX: ${p.prescription_number}</small>
                    <div style="margin-top:6px;">${itemsHtml}</div>
                </div>`;
            });
            document.getElementById('prescriptionResults').innerHTML = html;
        } else {
            document.getElementById('prescriptionResults').innerHTML = '<div style="text-align:center;padding:20px;color:#d32f2f;">No active prescriptions found</div>';
        }
    })
    .catch(() => {
        document.getElementById('prescriptionResults').innerHTML = '<div style="text-align:center;padding:20px;color:#d32f2f;">Search failed</div>';
    });
});

function loadPrescription(id, number) {
    fetch(`/pos/get-prescription/${id}`, {
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            activePrescription = data.data;
            closePrescriptionModal();
            Swal.fire({ 
                icon: 'success', 
                title: 'RX Loaded', 
                html: `
                    <p><strong>Patient:</strong> ${data.data.patient_name}</p>
                    <p><strong>RX #:</strong> ${data.data.prescription_number}</p>
                    <p><strong>Items:</strong> ${data.data.items.length}</p>
                `,
                timer: 2500, 
                showConfirmButton: false 
            });
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load prescription', 'error');
    });
}

// Close prescription modal on overlay click
document.getElementById('prescriptionOverlay').addEventListener('click', closePrescriptionModal);
</script>
@endsection