@extends('layouts.app')

@section('title', 'User & Access Management')

@section('content')
<style>
    /* Tabs Styles */
    .user-access-tabs {
        display: flex;
        background: white;
        border-radius: 10px;
        margin-bottom: 18px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .tab {
        flex: 1;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        color: #666;
        font-weight: 500;
        font-size: 13px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
    }
    .tab:hover {
        background: #f8f9fa;
        color: #1b5e20;
    }
    .tab.active {
        color: #1b5e20;
        border-bottom: 3px solid #1b5e20;
        background: #f1f8e9;
    }
    .tab i {
        font-size: 14px;
    }
    .tab .badge {
        font-size: 11px;
        padding: 2px 8px;
    }

    /* Permissions */
    .permissions-group {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 6px 8px !important;
        margin-top: 4px !important;
    }
    .permissions-group h6 {
        color: #1b5e20;
        font-size: 12px;
        margin-bottom: 8px;
        padding-bottom: 4px;
        border-bottom: 1px solid #ddd;
    }
    .perm-checkbox {
        display: inline-block;
        margin-right: 12px;
        margin-bottom: 4px;
    }
    .perm-checkbox label {
        font-size: 11px;
        margin-left: 3px;
    }
    .table-permissions {
        max-width: 300px;
        min-width: 250px;
    }

    /* Permission badges */
    .perm-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 2px 8px !important;
        border-radius: 16px;
        font-size: 10px !important;
        margin: 1px 3px 1px 0 !important;
        white-space: nowrap;
    }
    .perm-badge i {
        margin-right: 3px;
        font-size: 8px !important;
    }
    .role-icon {
        font-size: 14px;
        margin-right: 6px;
    }

    /* Custom Scrollbar */
    .card-body.p-0::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    .card-body.p-0::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .card-body.p-0::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 4px;
    }
    .card-body.p-0::-webkit-scrollbar-thumb:hover {
        background: #2e7d32;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
    }
    .form-check {
        padding: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-check:hover {
        background: #f8f9fa;
        border-radius: 4px;
    }
    .form-check-input {
        width: 14px !important;
        height: 14px !important;
        margin-top: 0 !important;
        flex-shrink: 0;
        cursor: pointer;
        accent-color: #0b7a33;
    }
    .form-check-label {
        font-size: 12px;
        cursor: pointer;
        margin: 0;
        padding: 1px 0;
        color: #333;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .form-check-label i {
        color: #0b7a33;
        font-size: 11px;
    }
    .btn-group {
        display: flex;
        gap: 3px;
    }

    /* Search/Filter Box */
    .search-filter-box {
        background: white;
        border-radius: 10px;
        padding: 12px 18px;
        margin-bottom: 18px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
    }
    .search-filter-box .form-control,
    .search-filter-box .form-select {
        font-size: 13px;
        padding: 5px 10px;
        height: 34px;
        border-radius: 6px;
    }
    .search-filter-box .input-group-text {
        font-size: 13px;
        padding: 5px 10px;
        background: white;
    }
    .search-filter-box .btn {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 6px;
    }

    .filter-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #1b5e20;
        padding: 2px 8px !important;
        border-radius: 12px;
        font-size: 11px !important;
        margin-left: 6px;
    }
    .filter-badge i {
        margin-right: 3px;
    }

    .role-label {
        font-weight: 500;
        padding: 3px 10px !important;
        border-radius: 4px;
        display: inline-block;
        font-size: 11px !important;
        border: 1px solid #ddd;
        background: white;
        color: #333;
    }

    /* Show More Button */
    .perm-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 3px;
    }
    .hidden-perms {
        display: none;
        flex-wrap: wrap;
        align-items: center;
        gap: 3px;
        width: 100%;
    }
    .hidden-perms.show {
        display: flex;
    }
    .hidden-perms-access {
        display: none;
        flex-wrap: wrap;
        align-items: center;
        gap: 3px;
        width: 100%;
    }
    .hidden-perms-access.show {
        display: flex;
    }
    .show-more-btn {
        background: none;
        border: none;
        color: #1b5e20;
        font-size: 10px !important;
        font-weight: 600;
        cursor: pointer;
        padding: 2px 8px !important;
        border-radius: 16px;
        background: #f1f8e9;
        transition: all 0.3s;
        white-space: nowrap;
    }
    .show-more-btn:hover {
        background: #c8e6c9;
        color: #0b7a33;
    }
    .show-more-btn i {
        margin-right: 3px;
        font-size: 9px !important;
    }
    .show-more-btn-access {
        background: none;
        border: none;
        color: #1b5e20;
        font-size: 10px !important;
        font-weight: 600;
        cursor: pointer;
        padding: 2px 8px !important;
        border-radius: 16px;
        background: #f1f8e9;
        transition: all 0.3s;
        white-space: nowrap;
    }
    .show-more-btn-access:hover {
        background: #c8e6c9;
        color: #0b7a33;
    }
    .show-more-btn-access i {
        margin-right: 3px;
        font-size: 9px !important;
    }

    /* ===== IMPROVED ACTION BUTTONS ===== */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 4px !important;
    }

    .btn-action {
        width: 28px !important;
        height: 28px !important;
        border: none;
        border-radius: 6px !important;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 12px !important;
        position: relative;
    }

    .btn-edit {
        background: #fff3e0;
        color: #e65100;
    }
    .btn-edit:hover {
        background: #ffe0b2;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(230, 81, 0, 0.25);
    }

    .btn-deactivate {
        background: #fce4ec;
        color: #c62828;
    }
    .btn-deactivate:hover {
        background: #f8bbd0;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(198, 40, 40, 0.25);
    }

    .btn-activate {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .btn-activate:hover {
        background: #c8e6c9;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(46, 125, 50, 0.25);
    }

    .btn-delete {
        background: #fbe9e7;
        color: #bf360c;
    }
    .btn-delete:hover {
        background: #ffccbc;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(191, 54, 12, 0.25);
    }

    .btn-action::after {
        content: attr(title);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        background: #333;
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        pointer-events: none;
    }
    .btn-action:hover::after {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) scale(1);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px !important;
        border-radius: 16px;
        font-size: 11px !important;
        font-weight: 600;
    }
    .status-badge i {
        font-size: 7px !important;
    }
    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .status-active i {
        color: #43a047;
    }
    .status-inactive {
        background: #fce4ec;
        color: #c62828;
    }
    .status-inactive i {
        color: #e53935;
    }

    /* Table */
    .table thead th {
        font-size: 12px;
        font-weight: 600;
        padding: 8px 10px;
        white-space: nowrap;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody td {
        padding: 8px 10px;
        vertical-align: middle;
        font-size: 13px;
    }
    .table-hover tbody tr:hover {
        background: #f8f9fa;
    }

    /* Card */
    .card-header {
        padding: 10px 15px !important;
    }
    .card-header h5 {
        font-size: 14px !important;
    }
    .card-footer {
        padding: 8px 15px !important;
        font-size: 13px !important;
    }
    .card-footer .pagination .page-link {
        padding: 4px 10px;
        font-size: 12px;
    }

    /* User Avatar */
    .user-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 13px !important;
    }
    .user-avatar + .ms-2 strong {
        font-size: 13px;
    }
    .user-avatar + .ms-2 small {
        font-size: 11px;
    }

    /* ===== MODAL STYLES ===== */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-container {
        background: white;
        border-radius: 12px;
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        padding: 12px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modal-header-custom h5 {
        color: white;
        margin: 0;
        font-size: 15px;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 0 6px;
        transition: all 0.3s;
    }
    .modal-close-btn:hover {
        transform: rotate(90deg);
    }

    .modal-body-custom {
        padding: 16px 20px;
        max-height: calc(90vh - 60px);
        overflow-y: auto;
    }

    .form-label-modal {
        font-weight: 600;
        font-size: 12px;
        color: #333;
        margin-bottom: 2px;
        display: block;
    }
    .form-label-modal .required {
        color: #dc3545;
    }

    .form-control-modal {
        width: 100%;
        padding: 5px 10px;
        border: 1.5px solid #e0e0e0;
        border-radius: 5px;
        font-size: 13px;
        transition: all 0.3s;
        height: 32px;
    }
    .form-control-modal:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 2px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .section-title-modal {
        font-size: 13px;
        font-weight: 600;
        color: #1b5e20;
        margin: 8px 0 5px 0;
    }
    .section-title-modal i {
        margin-right: 5px;
    }

    .section-divider-modal {
        border-top: 1px solid #e8f5e9;
        margin: 8px 0;
    }

    /* Role Option */
    .role-option-modal {
        padding: 6px 10px;
        border: 1.5px solid #e0e0e0;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 100%;
        margin-bottom: 4px;
        background: white;
    }
    .role-option-modal:hover {
        border-color: #0b7a33;
        background: #f8f9fa;
    }
    .role-option-modal.selected {
        border-color: #0b7a33;
        background: #e8f5e9;
        box-shadow: 0 0 0 2px rgba(11, 122, 51, 0.1);
    }
    .role-option-modal input[type="radio"] {
        margin: 0;
        flex-shrink: 0;
        cursor: pointer;
        accent-color: #0b7a33;
        width: 14px;
        height: 14px;
    }
    .role-option-modal .role-name-modal {
        font-weight: 500;
        font-size: 12px;
        text-align: center;
        cursor: pointer;
    }

    .avatar-upload-wrapper-modal {
        text-align: center;
        margin-bottom: 10px;
    }
    .avatar-upload-wrapper-modal small {
        display: block;
        margin-top: 3px;
        color: #999;
        font-size: 10px;
    }
    .avatar-preview-modal {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: #f8f9fa;
        border: 2px dashed #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #ccc;
        margin: 0 auto;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
    }
    .avatar-preview-modal:hover {
        border-color: #0b7a33;
        background: #f1f8e9;
    }
    .avatar-preview-modal img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-preview-modal.has-image {
        border-color: #0b7a33;
        border-style: solid;
    }
    .avatar-input-modal {
        display: none;
    }

    .form-hint-modal {
        font-size: 10px;
        color: #999;
        margin-top: 2px;
    }

    .btn-toggle-pass-modal {
        background: #f0f0f0;
        border: 1.5px solid #e0e0e0;
        border-left: none;
        border-radius: 0 5px 5px 0;
        padding: 0 10px;
        cursor: pointer;
        height: 32px;
        display: flex;
        align-items: center;
    }
    .btn-toggle-pass-modal:hover {
        background: #e0e0e0;
    }
    .btn-toggle-pass-modal i {
        font-size: 13px;
        color: #666;
    }

    .status-switch-modal {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 3px 0;
    }
    .status-switch-modal .form-check-input-modal {
        width: 34px;
        height: 18px;
        cursor: pointer;
        margin: 0;
        accent-color: #0b7a33;
    }
    .status-switch-modal .form-check-input-modal:checked {
        background-color: #0b7a33;
        border-color: #0b7a33;
    }
    .status-switch-modal .status-label-modal {
        font-weight: 500;
        font-size: 12px;
        margin: 0;
    }
    .status-switch-modal .status-label-modal.active {
        color: #0b7a33;
    }
    .status-switch-modal .status-label-modal.inactive {
        color: #dc3545;
    }
    .status-switch-modal .text-muted-modal {
        font-size: 11px;
        color: #999;
    }

    .modal-footer-custom {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #e8e8e8;
    }

    .btn-submit-modal {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        color: white;
        padding: 5px 18px;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-submit-modal:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(11, 122, 51, 0.3);
    }
    .btn-submit-modal:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel-modal {
        background: #f0f0f0;
        color: #666;
        padding: 5px 16px;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-cancel-modal:hover {
        background: #e0e0e0;
        color: #333;
    }

    .password-match-success-modal {
        color: #28a745;
        font-size: 11px;
        margin-top: 2px;
    }
    .password-match-error-modal {
        color: #dc3545;
        font-size: 11px;
        margin-top: 2px;
    }

    .modal-body-custom::-webkit-scrollbar {
        width: 4px;
    }
    .modal-body-custom::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .modal-body-custom::-webkit-scrollbar-thumb {
        background: #0b7a33;
        border-radius: 4px;
    }

    /* PERMISSION MODULES */
    .permission-module {
        border: 1px solid #e8f5e9;
        border-radius: 8px;
        padding: 10px 14px;
        background: #fafffe;
        transition: all 0.3s ease;
    }
    .permission-module:hover {
        border-color: #a5d6a7;
        box-shadow: 0 2px 8px rgba(11, 122, 51, 0.08);
    }
    .permission-module .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
        padding-bottom: 4px;
        border-bottom: 1px solid #f0f0f0;
    }
    .permission-module .module-header h6 {
        color: #1b5e20;
        font-weight: 600;
        font-size: 12px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .permission-module .module-header h6 .module-icon {
        font-size: 14px;
    }
    .permission-module .module-header .module-count {
        font-size: 10px;
        color: #999;
        font-weight: 400;
        margin-left: 4px;
    }
    .permission-module .module-body {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 2px 6px;
    }
    .permission-module .form-check {
        padding: 2px 4px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 4px;
        min-height: 24px;
    }
    .permission-module .form-check-input {
        width: 14px !important;
        height: 14px !important;
        margin: 0 !important;
        flex-shrink: 0;
        cursor: pointer;
        accent-color: #0b7a33;
    }
    .permission-module .form-check-input:checked {
        background-color: #0b7a33;
        border-color: #0b7a33;
    }
    .permission-module .form-check-label {
        font-size: 11px;
        color: #444;
        cursor: pointer;
        padding: 1px 0;
        line-height: 1.3;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .permission-module .form-check-label:hover {
        color: #0b7a33;
    }
    .module-select-all {
        padding: 1px 10px !important;
        font-size: 10px !important;
        border-radius: 4px !important;
        border-color: #a5d6a7 !important;
        color: #1b5e20 !important;
    }
    .module-select-all:hover {
        background: #e8f5e9 !important;
        border-color: #0b7a33 !important;
    }

    /* Permission Modules Colors */
    .permission-module.dashboard { border-left: 3px solid #1976d2; }
    .permission-module.inventory { border-left: 3px solid #f57c00; }
    .permission-module.pos { border-left: 3px solid #7b1fa2; }
    .permission-module.products { border-left: 3px solid #388e3c; }
    .permission-module.sales { border-left: 3px solid #c62828; }
    .permission-module.users { border-left: 3px solid #00838f; }
    .permission-module.permissions { border-left: 3px solid #6d4c41; }
    .permission-module.system { border-left: 3px solid #455a64; }
    .permission-module.others { border-left: 3px solid #78909c; }

    /* Modal Permissions List */
    #permissionsListAccess .form-check {
        padding: 3px 6px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
        min-height: 26px;
        border-radius: 4px;
        transition: background 0.2s;
    }
    #permissionsListAccess .form-check:hover {
        background: #f8fdf8;
    }
    #permissionsListAccess .form-check-input {
        width: 14px !important;
        height: 14px !important;
        margin: 0 !important;
        flex-shrink: 0;
        cursor: pointer;
        accent-color: #0b7a33;
    }
    #permissionsListAccess .form-check-input:checked {
        background-color: #0b7a33;
        border-color: #0b7a33;
    }
    #permissionsListAccess .form-check-label {
        font-size: 12px;
        cursor: pointer;
        margin: 0;
        padding: 1px 0;
        color: #333;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    #permissionsListAccess .form-check-label i {
        color: #0b7a33;
        font-size: 11px;
    }

    @media (max-width: 768px) {
        .modal-container {
            max-width: 100%;
            margin: 10px;
            max-height: 95vh;
        }
        .modal-body-custom {
            padding: 12px 15px;
        }
        .role-option-modal {
            padding: 4px 6px;
        }
        .role-name-modal {
            font-size: 11px;
        }
        .table thead th,
        .table tbody td {
            font-size: 12px;
            padding: 5px 6px;
        }
        .tab {
            font-size: 11px;
            padding: 8px 10px;
        }
        .search-filter-box {
            padding: 10px 12px;
        }
        .user-avatar {
            width: 28px !important;
            height: 28px !important;
            font-size: 11px !important;
        }
        .btn-action {
            width: 24px !important;
            height: 24px !important;
            font-size: 10px !important;
        }
        .role-label {
            font-size: 10px !important;
            padding: 2px 8px !important;
        }
        .perm-badge {
            font-size: 9px !important;
            padding: 1px 6px !important;
        }
        .status-badge {
            font-size: 10px !important;
            padding: 2px 8px !important;
        }
        .show-more-btn {
            font-size: 9px !important;
            padding: 1px 6px !important;
        }
        .show-more-btn-access {
            font-size: 9px !important;
            padding: 1px 6px !important;
        }
        .permission-module {
            padding: 8px 10px;
        }
        .permission-module .form-check-label {
            font-size: 11px;
        }
        .permission-module .module-body {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }
</style>

<div class="container-fluid">
    <!-- TABS -->
    <div class="user-access-tabs">
        <div class="tab active" data-tab="user-management">
            <i class="fas fa-users"></i> User Management (Employees)
            <span class="badge bg-success ms-2">{{ $users->total() }}</span>
        </div>
        <div class="tab" data-tab="access-management">
            <i class="fas fa-key"></i> Access Management (Permissions)
            <span class="badge bg-primary ms-2" id="roleCountBadge">0</span>
        </div>
    </div>

    <!-- Header Card -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); border: none; border-radius: 10px;">
                <div class="card-body" style="padding: 14px 20px;">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 8px 12px;">
                                <i class="fas fa-users-gear text-white" style="font-size: 22px;"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-0 text-white" style="font-size: 17px; font-weight: 600;">
                                User & Access Management
                            </h4>
                            <p class="mb-0 text-white-50" style="font-size: 12px;">
                                Manage employees, roles, and permissions
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== USER MANAGEMENT TAB ==================== -->
    <div id="user-management-tab" class="tab-content">
        
        <!-- Search and Filter Box -->
        <div class="search-filter-box">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12 mb-2 mb-lg-0">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchEmployee" class="form-control border-start-0" placeholder="Search employee...">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-2 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-filter text-muted"></i>
                        </span>
                        <select id="roleFilter" class="form-select border-start-0">
                            <option value="">Filter by Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                            <option value="Pharmacist">Pharmacist</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 text-end">
                    <button id="clearFilterBtn" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="fas fa-times me-1"></i> Clear Filters
                    </button>
                    <button id="addEmployeeBtn" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i> Add Employee
                    </button>
                    <span id="filterCount" class="text-muted ms-2" style="font-size: 13px;"></span>
                </div>
            </div>
            
            <div id="activeFilters" style="display: none; margin-top: 12px;">
                <span class="filter-badge" id="roleFilterBadge">
                    <i class="fas fa-filter"></i> <span id="roleFilterText"></span>
                </span>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2 text-success"></i> Employee Directory
                </h5>
            </div>
            <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="width: 22%">User</th>
                                <th style="width: 12%">Role</th>
                                <th style="width: 45%">Permissions</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 11%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            @foreach($users as $user)
                            @php
                                $roleName = $user->roles->first()->name ?? 'No Role';
                            @endphp
                            <tr data-user-id="{{ $user->id }}" data-user-name="{{ strtolower($user->full_name ?? $user->username) }}" data-user-email="{{ strtolower($user->email) }}" data-role="{{ strtolower($roleName) }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center user-avatar" 
                                             style="width: 32px; height: 32px; font-size: 13px;">
                                            {{ strtoupper(substr($user->full_name ?? $user->username, 0, 1)) }}
                                        </div>
                                        <div class="ms-2">
                                            <strong>{{ $user->full_name ?? $user->username }}</strong><br>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-label">
                                        {{ $roleName }}
                                    </span>
                                </td>
                                <td class="permissions-cell" data-user-id="{{ $user->id }}">
                                    <div class="permissions-group" id="perms-{{ $user->id }}">
                                        <div class="d-flex flex-wrap perm-container" id="perm-list-{{ $user->id }}">
                                            <span class="text-muted">Loading permissions...</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-circle"></i> Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-circle"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit edit-user" data-id="{{ $user->id }}" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action {{ $user->is_active ? 'btn-deactivate' : 'btn-activate' }} toggle-status" 
                                                data-id="{{ $user->id }}" 
                                                data-status="{{ $user->is_active }}" 
                                                title="{{ $user->is_active ? 'Deactivate User' : 'Activate User' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button class="btn-action btn-delete delete-user" data-id="{{ $user->id }}" title="Delete User">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- ==================== ACCESS MANAGEMENT TAB ==================== -->
    <div id="access-management-tab" class="tab-content" style="display: none;">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-success"></i> Roles & Permissions
                </h5>
            </div>
            
            <div class="p-3 border-bottom">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchRoleAccess" class="form-control border-start-0" placeholder="Search role...">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button id="addRoleFromAccessBtn" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i> Add Role
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="width: 20%; position: sticky; top: 0; background: #f8f9fa;">Role</th>
                                <th style="width: 65%; position: sticky; top: 0; background: #f8f9fa;">Permissions</th>
                                <th style="width: 15%; position: sticky; top: 0; background: #f8f9fa;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="permissionsTableBody">
                            <tr id="loadingRow">
                                <td colspan="3" class="text-center py-5">
                                    <i class="fas fa-spinner fa-pulse fa-2x text-success"></i>
                                    <p class="mt-2">Loading permissions...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <small class="text-muted">Manage roles and assign permissions</small>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ADD EMPLOYEE MODAL                          -->
<!-- ============================================ -->
<div id="addEmployeeModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header-custom">
            <h5><i class="fas fa-user-plus me-2"></i> Add New Employee</h5>
            <button type="button" class="modal-close-btn" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="modal-body-custom">
            <form id="addEmployeeForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="modal_submit" value="1">

                <!-- Profile Photo -->
                <div class="avatar-upload-wrapper-modal">
                    <div class="avatar-preview-modal" id="avatarPreviewModal">
                        <i class="fas fa-user"></i>
                    </div>
                    <small>Click to upload profile photo (optional)</small>
                    <input type="file" name="profile_photo" id="profilePictureModal" class="avatar-input-modal" accept="image/*">
                </div>

                <!-- Personal Information -->
                <div class="section-title-modal">
                    <i class="fas fa-user-circle text-success"></i> Personal Information
                </div>

                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label-modal">Full Name <span class="required">*</span></label>
                        <input type="text" name="full_name" class="form-control-modal" placeholder="Enter full name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-modal">Username <span class="required">*</span></label>
                        <input type="text" name="username" class="form-control-modal" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <label class="form-label-modal">Email Address <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control-modal" placeholder="Enter email address" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-modal">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control-modal" placeholder="Enter contact number">
                    </div>
                </div>

                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <label class="form-label-modal">Employee ID</label>
                        <input type="text" name="employee_id" class="form-control-modal" placeholder="Enter employee ID (optional)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-modal">Address</label>
                        <input type="text" name="address" class="form-control-modal" placeholder="Enter address (optional)">
                    </div>
                </div>

                <div class="section-divider-modal"></div>

                <!-- Account Information -->
                <div class="section-title-modal">
                    <i class="fas fa-lock text-success"></i> Account Information
                </div>

                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label-modal">Password <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="passwordModal" class="form-control-modal" placeholder="Enter password" required>
                            <button type="button" class="btn-toggle-pass-modal" data-target="passwordModal">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-hint-modal">Minimum 8 characters</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-modal">Confirm Password <span class="required">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="passwordConfirmModal" class="form-control-modal" placeholder="Confirm password" required>
                            <button type="button" class="btn-toggle-pass-modal" data-target="passwordConfirmModal">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchMsgModal"></div>
                    </div>
                </div>

                <div class="section-divider-modal"></div>

                <!-- Role Selection -->
                <div class="section-title-modal">
                    <i class="fas fa-user-tag text-success"></i> Assign Role <span class="required">*</span>
                </div>

                <div class="row g-2" id="rolesContainer">
                    <div class="col-12 text-center py-2">
                        <span class="text-muted">Loading roles...</span>
                    </div>
                </div>

                <div class="section-divider-modal"></div>

                <!-- Documents -->
                <div class="section-title-modal">
                    <i class="fas fa-file-alt text-success"></i> Documents (Optional)
                </div>

                <div class="row g-2">
                    <div class="col-md-12">
                        <label class="form-label-modal">Resume / CV</label>
                        <input type="file" name="resume" class="form-control-modal" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-hint-modal">PDF, DOC, DOCX, JPG, PNG (Max 5MB)</div>
                    </div>
                </div>

                <div class="section-divider-modal"></div>

                <!-- Account Status -->
                <div class="section-title-modal">
                    <i class="fas fa-toggle-on text-success"></i> Account Status
                </div>

                <div class="status-switch-modal">
                    <input class="form-check-input-modal" type="checkbox" name="is_active" id="isActiveModal" value="1" checked>
                    <span class="status-label-modal active" id="statusLabelModal">Active</span>
                    <span class="text-muted-modal">(User can login immediately)</span>
                </div>

                <!-- Buttons -->
                <div class="modal-footer-custom">
                    <button type="button" class="btn-cancel-modal" id="cancelModalBtn">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-submit-modal" id="submitModalBtn">
                        <i class="fas fa-save me-1"></i> Create Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add/Edit Role Modal -->
<div id="roleModalAccess" class="modal" style="display: none;">
    <div style="background: white; margin: 5% auto; padding: 0; width: 90%; max-width: 900px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0;" id="modalTitleAccess"><i class="fas fa-plus me-2"></i> Add Role</h4>
            <button class="closeModalAccess" style="background: none; border: none; color: white; font-size: 28px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px; max-height: 500px; overflow-y: auto;">
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" id="roleNameAccess" class="form-control" placeholder="Enter role name">
                <input type="hidden" id="roleIdAccess">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Permissions</label>
                <div id="permissionsListAccess">
                    <!-- Permissions will be loaded here -->
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-secondary closeModalAccessBtn">Cancel</button>
                <button type="button" id="saveRoleAccessBtn" class="btn btn-success">Save Role</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============================================================
// ✅ PERMISSION LABELS
// ============================================================
const permissionLabels = {
    'view dashboard': 'Dashboard',
    'view sales metrics': 'Sales Metrics',
    'view inventory metrics': 'Inventory Metrics',
    'view inventory': 'View Inventory',
    'view inventory read only': 'Inventory (Read Only)',
    'create inventory': 'Add Inventory',
    'edit inventory': 'Edit Inventory',
    'update stock': 'Update Stock',
    'view inventory reports': 'Inventory Reports',
    'view pos': 'POS',
    'process payment': 'Process Payment',
    'void transaction': 'Void Transaction',
    'print receipts': 'Print Receipts',
    'view receipts': 'View Receipts',
    'view own receipts': 'My Receipts',
    'view promos': 'View Promos',
    'manage promos': 'Manage Promos',
    'view discounts': 'View Discounts',
    'manage discounts': 'Manage Discounts',
    'view products': 'View Products',
    'create product': 'Add Product',
    'edit product': 'Edit Product',
    'delete product': 'Delete Product',
    'view categories': 'View Categories',
    'manage categories': 'Manage Categories',
    'view sales reports': 'Sales Reports',
    'export reports': 'Export Reports',
    'view users': 'View Users',
    'create users': 'Add Users',
    'edit users': 'Edit Users',
    'delete users': 'Delete Users',
    'view roles': 'View Roles',
    'create roles': 'Create Roles',
    'edit roles': 'Edit Roles',
    'delete roles': 'Delete Roles',
    'reset user passwords': 'Reset Passwords',
    'view permissions': 'View Permissions',
    'create permissions': 'Create Permissions',
    'edit permissions': 'Edit Permissions',
    'delete permissions': 'Delete Permissions',
    'manage roles': 'Manage Roles',
    'manage permissions': 'Manage Permissions',
    'view prescriptions': 'Prescriptions',
    'view settings': 'View Settings',
    'edit settings': 'Edit Settings',
    'view logs': 'View Logs',
    'delete logs': 'Delete Logs',
    'test permission': 'Test Permission',
    'view drug classifications': 'View Drug Classifications',
    'create drug classifications': 'Create Drug Classifications',
    'edit drug classifications': 'Edit Drug Classifications',
    'delete drug classifications': 'Delete Drug Classifications',
};

// ============================================================
// ✅ PERMISSION MODULES - TAMANG GROUPING
// ============================================================
const permissionModules = {
    'Dashboard': {
        icon: '📊',
        permissions: [
            'view dashboard',
            'view sales metrics',
            'view inventory metrics'
        ]
    },
    'Inventory': {
        icon: '📦',
        permissions: [
            'view inventory',
            'view inventory read only',
            'create inventory',
            'edit inventory',
            'update stock',
            'view inventory reports'
        ]
    },
    'POS & Transactions': {
        icon: '🛒',
        permissions: [
            'view pos',
            'process payment',
            'void transaction',
            'print receipts',
            'view receipts',
            'view own receipts',
            'view promos',
            'manage promos',
            'view discounts',
            'manage discounts'
        ]
    },
    'Products': {
        icon: '💊',
        permissions: [
            'view products',
            'create product',
            'edit product',
            'delete product',
            'view categories',
            'manage categories'
        ]
    },
    'Sales & Reports': {
        icon: '📈',
        permissions: [
            'view sales reports',
            'view sales metrics',
            'export reports',
            'view inventory reports'
        ]
    },
    'User Management': {
        icon: '👥',
        permissions: [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'reset user passwords'
        ]
    },
    'Permissions': {
        icon: '🔐',
        permissions: [
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'manage roles',
            'manage permissions'
        ]
    },
    'Prescriptions': {
        icon: '💊',
        permissions: [
            'view prescriptions'
        ]
    },
    'System': {
        icon: '⚙️',
        permissions: [
            'view settings',
            'edit settings',
            'view logs',
            'delete logs'
        ]
    }
};

// ============================================================
// ✅ LOAD ROLES FOR MODAL
// ============================================================
function loadRolesForModal() {
    $.ajax({
        url: '/roles/list',
        method: 'GET',
        success: function(response) {
            let html = '';
            if (response.success && response.roles.length > 0) {
                response.roles.forEach(function(role, index) {
                    html += `<div class="col-md-3 col-sm-6">
                        <label class="role-option-modal ${index === 0 ? 'selected' : ''}">
                            <input type="radio" name="role" value="${role.name}" ${index === 0 ? 'checked' : ''}>
                            <span class="role-name-modal">${role.name}</span>
                        </label>
                    </div>`;
                });
            } else {
                html = `<div class="col-12 text-muted text-center py-2">
                    <i class="fas fa-exclamation-circle me-1"></i> No roles available. Please add roles first.
                </div>`;
            }
            $('#rolesContainer').html(html);
            
            $('.role-option-modal').on('click', function() {
                $('.role-option-modal').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });
        },
        error: function() {
            $('#rolesContainer').html(`<div class="col-12 text-muted text-center py-2">
                <i class="fas fa-exclamation-circle me-1"></i> Error loading roles.
            </div>`);
        }
    });
}

// ============================================================
// ✅ LOAD USER PERMISSIONS (in Employee Table)
// ============================================================
function loadUserPermissions(userId, roleName) {
    $.ajax({
        url: '/permissions/data',
        method: 'GET',
        success: function(response) {
            if (response.success && response.roles) {
                const role = response.roles.find(r => r.name === roleName);
                if (role && role.permissions) {
                    displayPermissions(userId, role.permissions);
                } else {
                    $('#perm-list-' + userId).html('<span class="text-muted">No permissions assigned</span>');
                }
            }
        },
        error: function() {
            $('#perm-list-' + userId).html('<span class="text-muted">Error loading permissions</span>');
        }
    });
}

function displayPermissions(userId, permissions) {
    const maxDisplay = 5;
    let html = '';
    let total = permissions.length;
    
    if (total > 0) {
        const visiblePerms = permissions.slice(0, maxDisplay);
        const hiddenPerms = permissions.slice(maxDisplay);
        
        visiblePerms.forEach(perm => {
            const label = permissionLabels[perm.name] || perm.name;
            html += `<span class="perm-badge"><i class="fas fa-check-circle text-success"></i> ${label}</span>`;
        });
        
        if (hiddenPerms.length > 0) {
            html += `<button class="show-more-btn" data-user-id="${userId}">
                        <i class="fas fa-plus-circle"></i> +${hiddenPerms.length} more
                     </button>`;
            html += `<div class="hidden-perms" id="hidden-perms-${userId}">`;
            hiddenPerms.forEach(perm => {
                const label = permissionLabels[perm.name] || perm.name;
                html += `<span class="perm-badge"><i class="fas fa-check-circle text-success"></i> ${label}</span>`;
            });
            html += `</div>`;
        }
    } else {
        html = '<span class="text-muted">No permissions assigned</span>';
    }
    
    $('#perm-list-' + userId).html(html);
}

// ============================================================
// ✅ SHOW MORE TOGGLE - Employee Table
// ============================================================
$(document).on('click', '.show-more-btn', function() {
    const userId = $(this).data('user-id');
    const hiddenContainer = $(`#hidden-perms-${userId}`);
    
    if (hiddenContainer.hasClass('show')) {
        hiddenContainer.removeClass('show');
        const count = hiddenContainer.find('.perm-badge').length;
        $(this).html(`<i class="fas fa-plus-circle"></i> +${count} more`);
    } else {
        hiddenContainer.addClass('show');
        $(this).html(`<i class="fas fa-minus-circle"></i> Show less`);
    }
});

// ============================================================
// ✅ SHOW MORE TOGGLE - Access Management
// ============================================================
$(document).on('click', '.show-more-btn-access', function() {
    const roleId = $(this).data('role-id');
    const hiddenContainer = $(`#hidden-perms-access-${roleId}`);
    
    if (hiddenContainer.hasClass('show')) {
        hiddenContainer.removeClass('show');
        const count = hiddenContainer.find('.perm-badge').length;
        $(this).html(`<i class="fas fa-plus-circle"></i> +${count} more`);
    } else {
        hiddenContainer.addClass('show');
        $(this).html(`<i class="fas fa-minus-circle"></i> Show less`);
    }
});

// ============================================================
// ✅ FILTER EMPLOYEES
// ============================================================
function filterEmployees() {
    let search = $('#searchEmployee').val().toLowerCase().trim();
    let selectedRole = $('#roleFilter').val().toLowerCase();
    let visibleCount = 0;
    
    $('#employeeTableBody tr').each(function() {
        let userName = $(this).data('user-name') || '';
        let userEmail = $(this).data('user-email') || '';
        let userRole = $(this).data('role') || '';
        
        let matchSearch = userName.indexOf(search) > -1 || userEmail.indexOf(search) > -1;
        let matchRole = selectedRole === '' || userRole === selectedRole;
        
        let isVisible = matchSearch && matchRole;
        $(this).toggle(isVisible);
        if (isVisible) visibleCount++;
    });
    
    let filterText = '';
    if (selectedRole !== '') {
        let roleMap = {
            'admin': 'Admin',
            'cashier': 'Cashier',
            'pharmacy assistant': 'Pharmacy Assistant',
            'pharmacist': 'Pharmacist'
        };
        filterText = roleMap[selectedRole] || selectedRole;
        $('#roleFilterText').text(filterText);
        $('#activeFilters').show();
    } else {
        $('#activeFilters').hide();
    }
}

$('#searchEmployee').on('keyup', function() {
    filterEmployees();
});

$('#roleFilter').on('change', function() {
    filterEmployees();
});

$('#clearFilterBtn').click(function() {
    $('#searchEmployee').val('');
    $('#roleFilter').val('');
    filterEmployees();
});

// ============================================================
// ✅ TABS
// ============================================================
$('.tab').click(function() {
    $('.tab').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();
    const tabId = $(this).data('tab');
    $('#' + tabId + '-tab').show();
    
    if (tabId === 'access-management') {
        loadPermissionManagement();
    }
});

// ============================================================
// ✅ LOAD PERMISSION MANAGEMENT TABLE
// ============================================================
function loadPermissionManagement() {
    $('#permissionsTableBody').html('<tr><td colspan="3" class="text-center py-5"><i class="fas fa-spinner fa-pulse fa-2x text-success"></i><p class="mt-2">Loading permissions...</p></td></tr>');
    
    $.ajax({
        url: '/permissions/data',
        method: 'GET',
        success: function(response) {
            if (response.success && response.roles) {
                let html = '';
                let roleCount = response.roles.length;
                
                $('#roleCountBadge').text(roleCount);
                
                response.roles.forEach(role => {
                    const perms = role.permissions || [];
                    const maxDisplay = 5;
                    const visiblePerms = perms.slice(0, maxDisplay);
                    const hiddenPerms = perms.slice(maxDisplay);
                    
                    html += `<tr class="role-row-access" data-role-name="${role.name}">
                        <td style="vertical-align: middle;">
                            <span class="role-label">${role.name}</span>
                        </td>
                        <td class="permissions-cell" style="vertical-align: middle;">
                            <div class="permissions-group" style="padding: 6px 8px !important; margin-top: 0 !important;">
                                <div class="d-flex flex-wrap perm-container" id="perm-list-access-${role.id}">`;
                    
                    if (visiblePerms.length > 0) {
                        visiblePerms.forEach(perm => {
                            const label = permissionLabels[perm.name] || perm.name;
                            html += `<span class="perm-badge"><i class="fas fa-check-circle text-success"></i> ${label}</span>`;
                        });
                        
                        if (hiddenPerms.length > 0) {
                            html += `<button class="show-more-btn-access" data-role-id="${role.id}">
                                        <i class="fas fa-plus-circle"></i> +${hiddenPerms.length} more
                                     </button>
                                     <div class="hidden-perms-access" id="hidden-perms-access-${role.id}">`;
                            hiddenPerms.forEach(perm => {
                                const label = permissionLabels[perm.name] || perm.name;
                                html += `<span class="perm-badge"><i class="fas fa-check-circle text-success"></i> ${label}</span>`;
                            });
                            html += `</div>`;
                        }
                    } else {
                        html += `<span class="text-muted">No permissions assigned</span>`;
                    }
                    
                    html += `</div>
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            <div class="action-buttons">
                                <button class="btn-action btn-edit edit-role-access" data-id="${role.id}" data-name="${role.name}" title="Edit Role">
                                    <i class="fas fa-edit"></i>
                                </button>`;
                    
                    if (!['Admin', 'Cashier', 'Pharmacy Assistant', 'Pharmacist'].includes(role.name)) {
                        html += `<button class="btn-action btn-delete delete-role-access" data-id="${role.id}" data-name="${role.name}" title="Delete Role">
                                    <i class="fas fa-trash-alt"></i>
                                </button>`;
                    }
                    
                    html += `</div>
                        </td>
                    </tr>`;
                });
                $('#permissionsTableBody').html(html);
            } else {
                $('#roleCountBadge').text('0');
                $('#permissionsTableBody').html('<tr><td colspan="3" class="text-center py-5 text-danger">Failed to load permissions data</td></tr>');
            }
        },
        error: function() {
            $('#roleCountBadge').text('0');
            $('#permissionsTableBody').html('<tr><td colspan="3" class="text-center py-5 text-danger">Error loading permissions.</td></tr>');
        }
    });
}

// ============================================================
// ✅ LOAD ALL PERMISSIONS FOR MODAL
// ============================================================
function loadAllPermissions(selectedPermissions = []) {
    $.ajax({
        url: '{{ route("permissions.list") }}',
        method: 'GET',
        success: function(response) {
            let html = '';
            
            // Group permissions by module
            let groupedPermissions = {};
            let allPermissions = [];
            
            response.permissions.forEach(perm => {
                allPermissions.push(perm.name);
            });
            
            // Build module groups
            let allModulePermissions = [];
            Object.keys(permissionModules).forEach(moduleName => {
                const module = permissionModules[moduleName];
                const modulePerms = module.permissions.filter(p => allPermissions.includes(p));
                if (modulePerms.length > 0) {
                    groupedPermissions[moduleName] = modulePerms;
                    allModulePermissions = allModulePermissions.concat(modulePerms);
                }
            });
            
            // Find ungrouped permissions
            let ungroupedPerms = allPermissions.filter(p => !allModulePermissions.includes(p));
            
            // Top buttons
            html = `<div class="text-end mb-2">
                        <button type="button" id="selectAllPermissionsBtn" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-check-double me-1"></i> Select All
                        </button>
                        <button type="button" id="deselectAllPermissionsBtn" class="btn btn-sm btn-outline-secondary ms-1">
                            <i class="fas fa-times me-1"></i> Deselect All
                        </button>
                    </div>`;
            
            // Generate HTML for each module
            Object.keys(groupedPermissions).forEach(moduleName => {
                const module = permissionModules[moduleName];
                const perms = groupedPermissions[moduleName];
                
                let moduleClass = moduleName.toLowerCase().replace(/[^a-z]/g, '');
                if (moduleName === 'POS & Transactions') moduleClass = 'pos';
                if (moduleName === 'Sales & Reports') moduleClass = 'sales';
                if (moduleName === 'User Management') moduleClass = 'users';
                
                html += `<div class="permission-module ${moduleClass} mb-2">`;
                html += `<div class="module-header">`;
                html += `<h6><span class="module-icon">${module.icon}</span> ${moduleName} <span class="module-count">(${perms.length})</span></h6>`;
                html += `<button type="button" class="btn btn-sm btn-outline-success module-select-all" data-module="${moduleName}">
                            <i class="fas fa-check-double me-1"></i> Select All
                        </button>`;
                html += `</div>`;
                html += `<div class="module-body">`;
                
                perms.forEach(perm => {
                    const permData = response.permissions.find(p => p.name === perm);
                    const permId = permData ? permData.id : null;
                    if (!permId) return;
                    
                    const isChecked = selectedPermissions.includes(permId) ? 'checked' : '';
                    const label = perm.charAt(0).toUpperCase() + perm.slice(1);
                    
                    html += `<div class="form-check">`;
                    html += `<input class="form-check-input perm-checkbox-access" type="checkbox" value="${permId}" id="perm_${permId}" ${isChecked}>`;
                    html += `<label class="form-check-label" for="perm_${permId}">${label}</label>`;
                    html += `</div>`;
                });
                
                html += `</div>`;
                html += `</div>`;
            });
            
            // Add ungrouped permissions
            if (ungroupedPerms.length > 0) {
                html += `<div class="permission-module others mb-2">`;
                html += `<div class="module-header">`;
                html += `<h6><span class="module-icon">📌</span> Others <span class="module-count">(${ungroupedPerms.length})</span></h6>`;
                html += `<button type="button" class="btn btn-sm btn-outline-success module-select-all" data-module="others">
                            <i class="fas fa-check-double me-1"></i> Select All
                        </button>`;
                html += `</div>`;
                html += `<div class="module-body">`;
                
                ungroupedPerms.forEach(perm => {
                    const permData = response.permissions.find(p => p.name === perm);
                    const permId = permData ? permData.id : null;
                    if (!permId) return;
                    
                    const isChecked = selectedPermissions.includes(permId) ? 'checked' : '';
                    const label = perm.charAt(0).toUpperCase() + perm.slice(1);
                    
                    html += `<div class="form-check">`;
                    html += `<input class="form-check-input perm-checkbox-access" type="checkbox" value="${permId}" id="perm_${permId}" ${isChecked}>`;
                    html += `<label class="form-check-label" for="perm_${permId}">${label}</label>`;
                    html += `</div>`;
                });
                
                html += `</div>`;
                html += `</div>`;
            }
            
            $('#permissionsListAccess').html(html);
            
            // Module Select All
            $('.module-select-all').on('click', function() {
                const moduleCheckboxes = $(this).closest('.permission-module').find('.perm-checkbox-access');
                const allChecked = moduleCheckboxes.filter(':checked').length === moduleCheckboxes.length;
                moduleCheckboxes.prop('checked', !allChecked);
            });
            
            // Global Select All
            $('#selectAllPermissionsBtn').on('click', function() {
                $('.perm-checkbox-access').prop('checked', true);
            });
            
            // Global Deselect All
            $('#deselectAllPermissionsBtn').on('click', function() {
                $('.perm-checkbox-access').prop('checked', false);
            });
        }
    });
}

// ============================================================
// ✅ ADD ROLE
// ============================================================
$('#addRoleFromAccessBtn').click(function() {
    $('#modalTitleAccess').html('<i class="fas fa-plus me-2"></i> Add Role');
    $('#roleIdAccess').val('');
    $('#roleNameAccess').val('');
    loadAllPermissions([]);
    $('#roleModalAccess').fadeIn();
});

// ============================================================
// ✅ EDIT ROLE
// ============================================================
$(document).on('click', '.edit-role-access', function() {
    let roleId = $(this).data('id');
    let roleName = $(this).data('name');
    
    $('#modalTitleAccess').html('<i class="fas fa-edit me-2"></i> Edit Role');
    $('#roleIdAccess').val(roleId);
    $('#roleNameAccess').val(roleName);
    
    Swal.fire({ title: 'Loading...', text: 'Fetching permissions...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
    
    $.ajax({
        url: '/roles/' + roleId + '/permissions',
        method: 'GET',
        success: function(response) {
            Swal.close();
            loadAllPermissions(response.permissions);
            $('#roleModalAccess').fadeIn();
        },
        error: function() {
            Swal.close();
            loadAllPermissions([]);
            $('#roleModalAccess').fadeIn();
        }
    });
});

// ============================================================
// ✅ SAVE ROLE
// ============================================================
$('#saveRoleAccessBtn').click(function() {
    let roleId = $('#roleIdAccess').val();
    let roleName = $('#roleNameAccess').val().trim();
    let permissions = [];
    
    $('.perm-checkbox-access:checked').each(function() {
        permissions.push($(this).val());
    });
    
    if (!roleName) {
        Swal.fire({ icon: 'error', title: 'Error!', text: 'Please enter role name', confirmButtonColor: '#d33' });
        return;
    }
    
    Swal.fire({ title: 'Saving...', text: 'Please wait', allowOutsideClick: false, showConfirmButton: false, willOpen: () => { Swal.showLoading(); } });
    
    let url = roleId ? '/roles/' + roleId : '/roles';
    let requestData = { _token: '{{ csrf_token() }}', name: roleName, permissions: permissions };
    if (roleId) requestData._method = 'PUT';
    
    $.ajax({
        url: url,
        method: 'POST',
        data: requestData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({ icon: 'success', title: 'Success!', text: response.message, confirmButtonColor: '#0b7a33' }).then(() => {
                    $('#roleModalAccess').fadeOut();
                    loadPermissionManagement();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Error!', text: response.message, confirmButtonColor: '#d33' });
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to save role';
            if (xhr.responseJSON?.message) errorMsg = xhr.responseJSON.message;
            Swal.fire({ icon: 'error', title: 'Error!', text: errorMsg, confirmButtonColor: '#d33' });
        }
    });
});

// ============================================================
// ✅ DELETE ROLE
// ============================================================
$(document).on('click', '.delete-role-access', function() {
    let roleId = $(this).data('id');
    let roleName = $(this).data('name');
    
    Swal.fire({
        title: 'Delete Role?',
        text: `Are you sure you want to delete "${roleName}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/roles/' + roleId,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    Swal.fire('Deleted!', response.message, 'success').then(() => loadPermissionManagement());
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Failed to delete role', 'error');
                }
            });
        }
    });
});

// ============================================================
// ✅ SEARCH ROLE
// ============================================================
$(document).on('keyup', '#searchRoleAccess', function() {
    let search = $(this).val().toLowerCase();
    $('#permissionsTableBody tr.role-row-access').each(function() {
        let roleName = $(this).find('td:first').text().toLowerCase();
        $(this).toggle(roleName.indexOf(search) > -1);
    });
});

// ============================================================
// ✅ CLOSE MODAL
// ============================================================
$('.closeModalAccess, .closeModalAccessBtn').click(function() {
    $('#roleModalAccess').fadeOut();
});

// ============================================================
// ✅ OPEN ADD EMPLOYEE MODAL
// ============================================================
$('#addEmployeeBtn').on('click', function() {
    $('#addEmployeeModal').fadeIn(200);
    $('body').css('overflow', 'hidden');
    
    loadRolesForModal();
    
    $('#addEmployeeForm')[0].reset();
    $('#avatarPreviewModal').html('<i class="fas fa-user"></i>').removeClass('has-image');
    $('#passwordMatchMsgModal').html('');
    $('#passwordModal, #passwordConfirmModal').removeClass('is-valid is-invalid');
    $('#statusLabelModal').text('Active').removeClass('inactive').addClass('active');
    $('#submitModalBtn').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Create Employee');
});

// ============================================================
// ✅ CLOSE MODAL
// ============================================================
function closeModal() {
    $('#addEmployeeModal').fadeOut(200);
    $('body').css('overflow', 'auto');
}

$('#closeModalBtn, #cancelModalBtn').on('click', closeModal);

$('#addEmployeeModal').on('click', function(e) {
    if ($(e.target).is(this)) {
        closeModal();
    }
});

$(document).on('keydown', function(e) {
    if (e.key === 'Escape' && $('#addEmployeeModal').is(':visible')) {
        closeModal();
    }
});

// ============================================================
// ✅ MODAL FORM FUNCTIONS
// ============================================================
$('#profilePictureModal').on('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#avatarPreviewModal').html('<img src="' + e.target.result + '" alt="Profile">').addClass('has-image');
        }
        reader.readAsDataURL(file);
    }
});

$('#avatarPreviewModal').on('click', function() {
    $('#profilePictureModal').click();
});

$('.btn-toggle-pass-modal').on('click', function() {
    const targetId = $(this).data('target');
    const input = $('#' + targetId);
    const icon = $(this).find('i');
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});

function checkPasswordMatchModal() {
    const password = $('#passwordModal').val();
    const confirm = $('#passwordConfirmModal').val();
    const msgDiv = $('#passwordMatchMsgModal');
    if (confirm.length > 0) {
        if (password === confirm) {
            msgDiv.html('<span class="password-match-success-modal"><i class="fas fa-check-circle me-1"></i> Passwords match!</span>');
            $('#passwordConfirmModal').removeClass('is-invalid').addClass('is-valid');
            return true;
        } else {
            msgDiv.html('<span class="password-match-error-modal"><i class="fas fa-times-circle me-1"></i> Passwords do not match!</span>');
            $('#passwordConfirmModal').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
    } else {
        msgDiv.html('');
        $('#passwordConfirmModal').removeClass('is-valid is-invalid');
        return true;
    }
}

$('#passwordModal, #passwordConfirmModal').on('keyup', checkPasswordMatchModal);

$('#isActiveModal').on('change', function() {
    const label = $('#statusLabelModal');
    if ($(this).is(':checked')) {
        label.text('Active').removeClass('inactive').addClass('active');
    } else {
        label.text('Inactive').removeClass('active').addClass('inactive');
    }
});

// ============================================================
// ✅ FORM SUBMIT
// ============================================================
$('#addEmployeeForm').on('submit', function(e) {
    e.preventDefault();

    if (!checkPasswordMatchModal()) {
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'Please make sure your passwords match.',
            confirmButtonColor: '#d33'
        });
        return;
    }

    $('#submitModalBtn').prop('disabled', true);
    $('#submitModalBtn').html('<i class="fas fa-spinner fa-spin me-1"></i> Creating...');

    const formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Employee created successfully!',
                confirmButtonColor: '#0b7a33',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                closeModal();
                location.reload();
            });
        },
        error: function(xhr) {
            let errorMsg = 'Failed to create employee.';
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMsg = Object.values(errors).flat().join('\n');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMsg,
                confirmButtonColor: '#d33'
            });
            
            $('#submitModalBtn').prop('disabled', false);
            $('#submitModalBtn').html('<i class="fas fa-save me-1"></i> Create Employee');
        }
    });
});

// ============================================================
// ✅ INITIALIZE ON LOAD
// ============================================================
$(document).ready(function() {
    $('.permissions-cell').each(function() {
        let userId = $(this).data('user-id');
        let role = $(this).closest('tr').find('.role-label').text().trim();
        loadUserPermissions(userId, role);
    });
    
    filterEmployees();
});

// ============================================================
// ✅ EDIT USER
// ============================================================
$(document).on('click', '.edit-user', function() {
    let userId = $(this).data('id');
    window.location.href = '/users/' + userId + '/edit';
});

// ============================================================
// ✅ TOGGLE STATUS
// ============================================================
$(document).on('click', '.toggle-status', function(e) {
    e.preventDefault();
    let userId = $(this).data('id');
    let currentStatus = $(this).data('status');
    let actionText = currentStatus ? 'deactivate' : 'activate';
    
    Swal.fire({
        title: actionText.toUpperCase() + ' Employee?',
        text: 'Are you sure you want to ' + actionText + ' this employee?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + actionText + '!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/users/' + userId + '/toggle-status',
                method: 'POST',
                data: { _token: '{{ csrf_token() }}', is_active: !currentStatus },
                success: function(response) {
                    Swal.fire('Success!', response.message, 'success').then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to update status', 'error');
                }
            });
        }
    });
});

// ============================================================
// ✅ DELETE USER
// ============================================================
$(document).on('click', '.delete-user', function(e) {
    e.preventDefault();
    let userId = $(this).data('id');
    
    Swal.fire({
        title: 'Delete Employee?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/users/' + userId,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to delete employee', 'error');
                }
            });
        }
    });
});
</script>
@endsection