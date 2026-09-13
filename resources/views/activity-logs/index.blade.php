@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<style>
    /* ============================================
       ✨ PREMIUM & MODERN STYLE - ACTIVITY LOGS v2
       ============================================ */

    :root {
        --primary: #0b7a33;
        --primary-dark: #056b28;
        --primary-light: #e8f5e9;
        --primary-gradient: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        --border: #e9ecef;
        --text: #1a1a2e;
        --text-muted: #6c757d;
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.08);
        --shadow-lg: 0 8px 40px rgba(0,0,0,0.12);
        --radius: 14px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== FADE ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes actionPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .animate-in {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }

    .animate-in:nth-child(1) { animation-delay: 0.05s; }
    .animate-in:nth-child(2) { animation-delay: 0.10s; }
    .animate-in:nth-child(3) { animation-delay: 0.15s; }
    .animate-in:nth-child(4) { animation-delay: 0.20s; }
    .animate-in:nth-child(5) { animation-delay: 0.25s; }

    /* ===== HEADER BOX ===== */
    .activity-header {
        background: var(--primary-gradient);
        border-radius: var(--radius);
        padding: 24px 30px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 6px 30px rgba(11, 122, 51, 0.30);
        position: relative;
        overflow: hidden;
    }

    .activity-header::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -5%;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        z-index: 0;
    }

    .activity-header::after {
        content: '';
        position: absolute;
        bottom: -70%;
        left: 15%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 50%;
        z-index: 0;
    }

    .activity-header .header-left {
        position: relative;
        z-index: 1;
    }

    .activity-header .header-left h2 {
        color: #ffffff;
        font-size: 28px;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 14px;
        letter-spacing: -0.5px;
    }

    .activity-header .header-left h2 i {
        background: rgba(255, 255, 255, 0.18);
        padding: 12px;
        border-radius: 14px;
        font-size: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        backdrop-filter: blur(4px);
    }

    .activity-header .header-left .subtitle {
        color: rgba(255, 255, 255, 0.75);
        font-size: 13px;
        font-weight: 500;
        margin-top: 4px;
        margin-left: 4px;
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
        padding: 10px 22px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        letter-spacing: 0.2px;
    }

    .activity-header .header-right .btn-header i {
        font-size: 14px;
    }

    .activity-header .header-right .btn-header.btn-clear-old {
        background: rgba(255, 193, 7, 0.95);
        color: #1a1a2e;
    }

    .activity-header .header-right .btn-header.btn-clear-old:hover {
        background: #ffc107;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.45);
    }

    .activity-header .header-right .btn-header.btn-export {
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary);
    }

    .activity-header .header-right .btn-header.btn-export:hover {
        background: #ffffff;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.35);
    }

    /* ===== TABS ===== */
    .tabs-container {
        display: flex;
        gap: 6px;
        margin-bottom: 24px;
        background: white;
        border-radius: var(--radius);
        padding: 6px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .tab-btn {
        flex: 1;
        padding: 14px 24px;
        border: none;
        background: transparent;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        position: relative;
    }

    .tab-btn i {
        font-size: 16px;
    }

    .tab-btn:hover {
        background: var(--primary-light);
        color: var(--primary);
    }

    .tab-btn.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 16px rgba(11, 122, 51, 0.30);
    }

    .tab-btn.active i {
        color: white;
    }

    .tab-btn .badge-tab {
        background: rgba(255,255,255,0.2);
        color: inherit;
        font-size: 11px;
        padding: 2px 10px;
        border-radius: 50px;
        font-weight: 700;
    }

    .tab-btn.active .badge-tab {
        background: rgba(255,255,255,0.25);
    }

    .tab-btn:not(.active) .badge-tab {
        background: #e9ecef;
        color: var(--text-muted);
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
        border-radius: var(--radius);
        padding: 20px 22px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: var(--transition);
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient);
        opacity: 0;
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .stat-card:hover::after {
        opacity: 1;
    }

    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
    }

    .stat-card .stat-icon.green { background: var(--primary-light); color: var(--primary); }
    .stat-card .stat-icon.blue { background: #e3f2fd; color: #1565c0; }
    .stat-card .stat-icon.orange { background: #fff3e0; color: #e65100; }
    .stat-card .stat-icon.purple { background: #f3e5f5; color: #6a1b9a; }

    .stat-card .stat-number {
        font-size: 30px;
        font-weight: 800;
        color: var(--text);
        line-height: 1.1;
        letter-spacing: -1px;
        font-variant-numeric: tabular-nums;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 4px;
    }

    .stat-card .stat-change {
        font-size: 12px;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 6px;
    }

    .stat-card .stat-change.up { background: #d4edda; color: #155724; }
    .stat-card .stat-change.down { background: #f8d7da; color: #721c24; }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        background: white;
        padding: 20px 22px;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .filter-bar:hover {
        box-shadow: var(--shadow-md);
    }

    .filter-bar .form-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }

    .filter-bar .form-select,
    .filter-bar .form-control {
        font-size: 13px;
        border-radius: 10px;
        border: 1.5px solid #dee2e6;
        padding: 9px 14px;
        height: 42px;
        background: #fafbfc;
        transition: var(--transition);
        color: var(--text);
    }

    .filter-bar .form-select:focus,
    .filter-bar .form-control:focus {
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(11, 122, 51, 0.10);
    }

    .filter-bar .form-select:hover,
    .filter-bar .form-control:hover {
        border-color: #b0b8c0;
    }

    .btn-filter {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 9px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        transition: var(--transition);
        height: 42px;
        letter-spacing: 0.3px;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(11, 122, 51, 0.35);
        color: white;
    }

    .btn-filter:active {
        transform: translateY(0);
    }

    .btn-reset {
        background: #f8f9fa;
        color: var(--text-muted);
        border: 1.5px solid #dee2e6;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        transition: var(--transition);
        height: 42px;
    }

    .btn-reset:hover {
        background: #e9ecef;
        border-color: #ced4da;
        transform: translateY(-2px);
    }

    /* ===== TABLE ===== */
    .table-wrapper {
        background: white;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .table-wrapper:hover {
        box-shadow: var(--shadow-md);
    }

    .table-header {
        padding: 18px 24px;
        background: #fafbfc;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-header h5 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-header h5 i {
        color: var(--primary);
    }

    .table-header .badge-count {
        background: var(--primary-gradient);
        color: white;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 18px;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(11, 122, 51, 0.20);
    }

    .table-scroll {
        overflow-y: auto;
        max-height: 600px;
    }

    .table-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f3f5;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #c1c7cd;
        border-radius: 6px;
    }

    .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #a8b0b8;
    }

    .table-scroll table {
        width: 100%;
        font-size: 13px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-scroll thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        padding: 14px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        border-bottom: 2px solid var(--border);
        z-index: 5;
        white-space: nowrap;
    }

    .table-scroll thead th:first-child {
        border-top-left-radius: 4px;
    }

    .table-scroll thead th:last-child {
        border-top-right-radius: 4px;
    }

    .table-scroll tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
        color: var(--text);
        font-size: 13px;
        transition: background 0.15s;
    }

    .table-scroll tbody tr {
        transition: background 0.2s;
    }

    .table-scroll tbody tr:hover td {
        background-color: var(--primary-light);
    }

    .table-scroll tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== USER AVATAR ===== */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        transition: var(--transition);
    }

    .user-avatar:hover {
        transform: scale(1.08);
    }

    .user-avatar.green { background: linear-gradient(135deg, #28a745, #1e7e34); }
    .user-avatar.blue { background: linear-gradient(135deg, #007bff, #0056b3); }
    .user-avatar.orange { background: linear-gradient(135deg, #fd7e14, #e8590c); }
    .user-avatar.purple { background: linear-gradient(135deg, #6f42c1, #563d7c); }
    .user-avatar.red { background: linear-gradient(135deg, #dc3545, #a71d2a); }
    .user-avatar.teal { background: linear-gradient(135deg, #20c997, #158f74); }

    .user-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--text);
    }

    .user-email {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* ============================================
       🎨 ACTION BADGE - DYNAMIC COLOR GENERATOR
       ============================================ */

    .action-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.08);
    }

    .action-badge:hover {
        transform: scale(1.04);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .action-badge i {
        font-size: 12px;
    }

    .action-create { background: #d4edda; color: #155724; border-color: #a3d9a5; }
    .action-update { background: #cce5ff; color: #004085; border-color: #a3c9f5; }
    .action-delete { background: #f8d7da; color: #721c24; border-color: #f0b4b8; }
    .action-deduct { background: #d1ecf1; color: #0c5460; border-color: #a8dbe3; }
    .action-transfer { background: #e8daef; color: #6f42c1; border-color: #d1b3e0; }
    .action-login { background: #d1ecf1; color: #0c5460; border-color: #a8dbe3; }
    .action-logout { background: #e9ecef; color: #495057; border-color: #ced4da; }
    .action-add { background: #c8e6c9; color: #1b5e20; border-color: #81c784; }
    .action-edit { background: #bbdefb; color: #0d47a1; border-color: #64b5f6; }
    .action-remove { background: #ffcdd2; color: #b71c1c; border-color: #ef9a9a; }
    .action-approve { background: #c8e6c9; color: #1b5e20; border-color: #81c784; }
    .action-reject { background: #ffcdd2; color: #b71c1c; border-color: #ef9a9a; }
    .action-cancel { background: #ffcdd2; color: #b71c1c; border-color: #ef9a9a; }
    .action-verify { background: #b2dfdb; color: #004d40; border-color: #4db6ac; }
    .action-confirm { background: #b2dfdb; color: #004d40; border-color: #4db6ac; }
    .action-pending { background: #fff9c4; color: #f57f17; border-color: #fff176; }
    .action-process { background: #fff9c4; color: #f57f17; border-color: #fff176; }
    .action-complete { background: #c8e6c9; color: #1b5e20; border-color: #81c784; }
    .action-failed { background: #ffcdd2; color: #b71c1c; border-color: #ef9a9a; }
    .action-sync { background: #e1f5fe; color: #01579b; border-color: #81d4fa; }
    .action-import { background: #f3e5f5; color: #4a148c; border-color: #ce93d8; }
    .action-export { background: #e8eaf6; color: #1a237e; border-color: #9fa8da; }
    .action-print { background: #e0f7fa; color: #006064; border-color: #80deea; }
    .action-view { background: #e3f2fd; color: #0d47a1; border-color: #90caf9; }
    .action-search { background: #e3f2fd; color: #0d47a1; border-color: #90caf9; }
    .action-save { background: #c8e6c9; color: #1b5e20; border-color: #81c784; }
    .action-submit { background: #b2dfdb; color: #004d40; border-color: #4db6ac; }
    .action-reset { background: #e9ecef; color: #495057; border-color: #ced4da; }
    .action-default { background: #f1f3f5; color: #495057; border-color: #ced4da; }

    .action-dynamic {
        position: relative;
        overflow: hidden;
        animation: actionPulse 2s ease-in-out infinite;
    }

    .action-dynamic {
        --hue: calc(var(--action-index, 0) * 25 + 180);
        background: hsl(var(--hue), 70%, 92%);
        color: hsl(var(--hue), 80%, 25%);
        border-color: hsl(var(--hue), 70%, 70%);
    }

    .action-dynamic i {
        color: hsl(var(--hue), 80%, 35%);
    }

    .action-rainbow {
        background: linear-gradient(135deg, 
            #ff6b6b, #feca57, #48dbfb, #1dd1a1, #5f27cd, #ff6b6b);
        background-size: 300% 300%;
        color: white;
        border: none;
        animation: rainbowMove 4s ease-in-out infinite;
        font-weight: 700;
        text-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .action-rainbow i {
        color: white;
    }

    @keyframes rainbowMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* ============================================
       🎨 MODULE BADGE - DYNAMIC COLOR GENERATOR
       ============================================ */

    .module-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.08);
    }

    .module-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .module-badge i {
        font-size: 12px;
    }

    .module-inventory { background: #e8f5e9; color: #2e7d32; border-color: #a5d6a7; }
    .module-pos { background: #e3f2fd; color: #1565c0; border-color: #90caf9; }
    .module-categories { background: #fff3e0; color: #e65100; border-color: #ffcc80; }
    .module-users { background: #f3e5f5; color: #6a1b9a; border-color: #ce93d8; }
    .module-profile { background: #e0f2f1; color: #00695c; border-color: #80cbc4; }
    .module-settings { background: #fce4ec; color: #880e4f; border-color: #f48fb1; }
    .module-promos { background: #fff9c4; color: #f57f17; border-color: #fff176; }
    .module-discounts { background: #e8eaf6; color: #283593; border-color: #9fa8da; }
    .module-auth { background: #e0f7fa; color: #006064; border-color: #80deea; }
    .module-reports { background: #fce4ec; color: #c62828; border-color: #ef9a9a; }
    .module-dashboard { background: #e8eaf6; color: #1a237e; border-color: #9fa8da; }
    .module-orders { background: #fff3e0; color: #bf360c; border-color: #ffab91; }
    .module-payments { background: #e0f2f1; color: #004d40; border-color: #80cbc4; }
    .module-returns { background: #fbe9e7; color: #bf360c; border-color: #ffab91; }
    .module-warehouse { background: #f1f8e9; color: #33691e; border-color: #aed581; }
    .module-suppliers { background: #e1f5fe; color: #01579b; border-color: #81d4fa; }
    .module-customers { background: #fce4ec; color: #880e4f; border-color: #f48fb1; }
    .module-employees { background: #f3e5f5; color: #4a148c; border-color: #ce93d8; }
    .module-attendance { background: #e8f5e9; color: #1b5e20; border-color: #a5d6a7; }
    .module-leaves { background: #fff8e1; color: #f57f17; border-color: #ffe082; }
    .module-payroll { background: #e3f2fd; color: #0d47a1; border-color: #90caf9; }
    .module-tasks { background: #f1f8e9; color: #33691e; border-color: #aed581; }
    .module-projects { background: #fce4ec; color: #880e4f; border-color: #f48fb1; }
    .module-tickets { background: #fff3e0; color: #e65100; border-color: #ffcc80; }
    .module-support { background: #e0f7fa; color: #006064; border-color: #80deea; }
    .module-announcements { background: #f3e5f5; color: #4a148c; border-color: #ce93d8; }
    .module-notifications { background: #e8eaf6; color: #1a237e; border-color: #9fa8da; }
    .module-default { background: #f1f3f5; color: #495057; border-color: #ced4da; }

    .module-dynamic {
        position: relative;
        overflow: hidden;
        animation: modulePulse 2s ease-in-out infinite;
    }

    @keyframes modulePulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .module-dynamic {
        --hue: calc(var(--module-index, 0) * 25 + 180);
        background: hsl(var(--hue), 70%, 92%);
        color: hsl(var(--hue), 80%, 25%);
        border-color: hsl(var(--hue), 70%, 70%);
    }

    .module-dynamic i {
        color: hsl(var(--hue), 80%, 35%);
    }

    .module-rainbow {
        background: linear-gradient(135deg, 
            #ff6b6b, #feca57, #48dbfb, #1dd1a1, #5f27cd, #ff6b6b);
        background-size: 300% 300%;
        color: white;
        border: none;
        animation: rainbowMove 4s ease-in-out infinite;
        font-weight: 700;
        text-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .module-rainbow i {
        color: white;
    }

    /* ===== DESCRIPTION BOX ===== */
    .description-cell {
        max-width: 230px;
        word-wrap: break-word;
        white-space: normal;
        font-size: 13px;
        color: var(--text);
        line-height: 1.4;
    }

    .description-box {
        background: #f8f9fa;
        padding: 8px 14px;
        border-radius: 8px;
        border-left: 4px solid var(--primary);
        color: #495057;
        font-size: 12px;
        line-height: 1.5;
        word-wrap: break-word;
        white-space: normal;
        max-width: 230px;
        transition: var(--transition);
        position: relative;
    }

    .description-box:hover {
        background: var(--primary-light);
        border-left-color: #0b7a33;
        color: var(--text);
        box-shadow: 0 2px 8px rgba(11, 122, 51, 0.10);
    }

    .description-box .truncate-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .description-box .expand-btn {
        color: var(--primary);
        font-weight: 600;
        font-size: 11px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        margin-top: 2px;
    }

    .description-box .expand-btn:hover {
        text-decoration: underline;
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge i {
        font-size: 10px;
    }

    .status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.failed {
        background: #f8d7da;
        color: #721c24;
    }

    /* ===== DATE/TIME ===== */
    .date-cell {
        white-space: nowrap;
        font-size: 12px;
        line-height: 1.5;
    }

    .date-cell .date {
        font-weight: 600;
        color: var(--text);
    }

    .date-cell .time {
        color: var(--text-muted);
        font-size: 11px;
        display: block;
    }

    /* ===== IP ADDRESS ===== */
    .ip-cell {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: var(--text-muted);
        background: #f8f9fa;
        padding: 2px 10px;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }

    .empty-state .empty-icon {
        font-size: 60px;
        margin-bottom: 16px;
        opacity: 0.25;
        color: var(--primary);
        display: block;
    }

    .empty-state p {
        font-size: 18px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
    }

    .empty-state small {
        font-size: 14px;
        color: var(--text-muted);
    }

    /* ===== TOOLTIP ===== */
    .custom-tooltip {
        position: relative;
        cursor: help;
    }

    .custom-tooltip .tooltip-text {
        visibility: hidden;
        opacity: 0;
        width: 220px;
        background: #1a1a2e;
        color: white;
        text-align: left;
        padding: 10px 14px;
        border-radius: 8px;
        position: absolute;
        z-index: 100;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        transition: all 0.3s ease;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.5;
        box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    }

    .custom-tooltip .tooltip-text::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 6px;
        border-style: solid;
        border-color: #1a1a2e transparent transparent transparent;
    }

    .custom-tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
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
            padding: 20px 24px;
        }

        .activity-header .header-right {
            width: 100%;
        }

        .activity-header .header-right .btn-header {
            flex: 1;
            justify-content: center;
        }

        .tabs-container {
            flex-direction: column;
        }

        .tab-btn {
            width: 100%;
        }

        .filter-bar .row {
            flex-direction: column;
            gap: 10px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card {
            padding: 16px 18px;
        }

        .stat-card .stat-number {
            font-size: 24px;
        }

        .activity-header {
            padding: 16px 18px;
        }

        .activity-header .header-left h2 {
            font-size: 22px;
        }

        .activity-header .header-left h2 i {
            padding: 10px;
            font-size: 17px;
        }

        .table-header {
            flex-direction: column;
            gap: 8px;
            align-items: flex-start;
            padding: 14px 18px;
        }

        .description-cell {
            max-width: 140px;
        }

        .description-box {
            max-width: 140px;
            font-size: 11px;
            padding: 6px 10px;
        }

        .tab-btn {
            font-size: 13px;
            padding: 12px 14px;
        }

        .filter-bar {
            padding: 16px 18px;
        }

        .table-scroll tbody td {
            padding: 10px 12px;
            font-size: 12px;
        }

        .table-scroll thead th {
            padding: 10px 12px;
            font-size: 10px;
        }

        .date-cell .time {
            font-size: 10px;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .stat-card {
            padding: 14px 16px;
        }

        .stat-card .stat-number {
            font-size: 20px;
        }

        .stat-card .stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .activity-header .header-left h2 {
            font-size: 19px;
        }

        .activity-header .header-left h2 i {
            padding: 8px;
            font-size: 15px;
        }

        .activity-header .header-right .btn-header {
            font-size: 12px;
            padding: 8px 14px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            font-size: 13px;
        }

        .user-name {
            font-size: 12px;
        }

        .user-email {
            font-size: 10px;
        }

        .action-badge,
        .module-badge,
        .status-badge {
            font-size: 10px;
            padding: 3px 10px;
        }

        .ip-cell {
            font-size: 10px;
            padding: 1px 8px;
        }

        .table-scroll {
            max-height: 400px;
        }

        .table-scroll tbody td,
        .table-scroll thead th {
            padding: 8px 10px;
        }

        .btn-filter,
        .btn-reset {
            height: 36px;
            font-size: 12px;
            padding: 6px 14px;
        }

        .filter-bar .form-select,
        .filter-bar .form-control {
            height: 36px;
            font-size: 12px;
            padding: 6px 10px;
        }
    }
</style>

<div class="container-fluid px-3">

    {{-- ===== HEADER BOX ===== --}}
    <div class="activity-header animate-in">
        <div class="header-left">
            <h2>
                <i class="fas fa-clock-rotate-left"></i>
                Activity Logs
            </h2>
            <div class="subtitle">
                <i class="fas fa-circle me-1" style="font-size: 6px; vertical-align: middle;"></i>
                Track and monitor all system activities
            </div>
        </div>
        
        @if(auth()->user()->hasRole('Admin'))
        <div class="header-right">
            <button id="clearOldBtn" class="btn-header btn-clear-old" title="Remove logs older than 30 days">
                <i class="fas fa-trash-can"></i> Clear Old Logs
            </button>
            <button id="exportBtn" class="btn-header btn-export" title="Export logs to CSV">
                <i class="fas fa-file-export"></i> Export
            </button>
        </div>
        @endif
    </div>

    {{-- ===== TABS ===== --}}
    <div class="tabs-container animate-in">
        <a href="{{ route('activity-logs.index', ['tab' => 'personal']) }}" class="tab-btn {{ ($tab ?? 'personal') == 'personal' ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            My Activity Logs
        </a>
        @if(auth()->user()->hasRole('Admin'))
        <a href="{{ route('activity-logs.index', ['tab' => 'all']) }}" class="tab-btn {{ ($tab ?? 'personal') == 'all' ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            All Employee Activity
        </a>
        @endif
    </div>

    {{-- ===== FILTER BAR ===== --}}
    <div class="filter-bar animate-in" id="filterBar">
        <div class="row g-3 align-items-end">
            @if(auth()->user()->hasRole('Admin'))
            <div class="col-md-2 col-sm-6" id="userFilterContainer">
                <label class="form-label"><i class="fas fa-user me-1"></i> User</label>
                <select id="filterUser" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->full_name ?? $user->username }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-2 col-sm-6">
                <label class="form-label"><i class="fas fa-tag me-1"></i> Action</label>
                <select id="filterAction" class="form-select">
                    <option value="">All Actions</option>
                    @foreach($actions ?? [] as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ ucfirst($action) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 col-sm-6">
                <label class="form-label"><i class="fas fa-cube me-1"></i> Module</label>
                <select id="filterModule" class="form-select">
                    <option value="">All Modules</option>
                    @foreach($modules ?? [] as $module)
                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                            {{ $module }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 col-sm-6">
                <label class="form-label"><i class="fas fa-calendar-day me-1"></i> Date From</label>
                <input type="date" id="startDate" class="form-control" value="{{ $startDate ?? now()->format('Y-m-d') }}">
            </div>

            <div class="col-md-2 col-sm-6">
                <label class="form-label"><i class="fas fa-calendar-day me-1"></i> Date To</label>
                <input type="date" id="endDate" class="form-control" value="{{ $endDate ?? now()->format('Y-m-d') }}">
            </div>

            <div class="col-md-2 col-sm-6">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button id="applyFilterBtn" class="btn-filter flex-grow-1">
                        <i class="fas fa-search me-1"></i> Apply
                    </button>
                    <button id="resetFilterBtn" class="btn-reset" title="Reset to today">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== STATS CARDS ===== --}}
    <div class="stats-grid" id="statsGrid">
        <div class="stat-card animate-in">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Activities</div>
                    <div class="stat-number" id="statTotal">{{ number_format($stats['total'] ?? 0) }}</div>
                </div>
                <div class="stat-icon green">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>
        <div class="stat-card animate-in">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Today's Activity</div>
                    <div class="stat-number" id="statToday">{{ number_format($stats['today'] ?? 0) }}</div>
                </div>
                <div class="stat-icon blue">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
        <div class="stat-card animate-in">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Active Modules</div>
                    <div class="stat-number" id="statModules">{{ number_format($stats['modules'] ?? 0) }}</div>
                </div>
                <div class="stat-icon orange">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
        </div>
        <div class="stat-card animate-in">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Unique Users</div>
                    <div class="stat-number" id="statUsers">{{ number_format($stats['unique_users'] ?? 0) }}</div>
                </div>
                <div class="stat-icon purple">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="table-wrapper animate-in">
        <div class="table-header">
            <h5>
                <i class="fas fa-history"></i>
                <span id="tableTitle">{{ ($tab ?? 'personal') == 'personal' ? 'My Activity Logs' : 'All Employee Activity' }}</span>
            </h5>
            <span class="badge-count" id="logCount">
                <i class="fas fa-file-lines me-1"></i>
                {{ $logs->count() }} {{ $logs->count() == 1 ? 'record' : 'records' }}
            </span>
        </div>
        <div class="table-scroll" id="logsTable">
            @include('activity-logs.partials.table', ['logs' => $logs])
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // ============================================
        // 🎨 DYNAMIC ACTION COLOR ASSIGNMENT
        // ============================================
        function assignActionColors() {
            const actionColors = {
                'create': 'action-create',
                'update': 'action-update',
                'delete': 'action-delete',
                'deduct': 'action-deduct',
                'transfer': 'action-transfer',
                'login': 'action-login',
                'logout': 'action-logout',
                'add': 'action-add',
                'edit': 'action-edit',
                'remove': 'action-remove',
                'approve': 'action-approve',
                'reject': 'action-reject',
                'cancel': 'action-cancel',
                'verify': 'action-verify',
                'confirm': 'action-confirm',
                'pending': 'action-pending',
                'process': 'action-process',
                'complete': 'action-complete',
                'failed': 'action-failed',
                'sync': 'action-sync',
                'import': 'action-import',
                'export': 'action-export',
                'print': 'action-print',
                'view': 'action-view',
                'search': 'action-search',
                'save': 'action-save',
                'submit': 'action-submit',
                'reset': 'action-reset',
                'default': 'action-default'
            };

            document.querySelectorAll('.action-badge').forEach(function(badge, index) {
                let actionName = badge.getAttribute('data-action') || 
                                badge.textContent.trim().toLowerCase().replace(/\s+/g, '');
                
                let className = actionColors[actionName];
                
                if (className) {
                    badge.className = 'action-badge ' + className;
                } else {
                    badge.classList.remove('action-dynamic', 'action-rainbow');
                    
                    if (index % 7 === 0) {
                        badge.className = 'action-badge action-rainbow';
                    } else {
                        let hash = 0;
                        for (let i = 0; i < actionName.length; i++) {
                            hash = actionName.charCodeAt(i) + ((hash << 5) - hash);
                        }
                        let hue = Math.abs(hash) % 360;
                        
                        badge.style.setProperty('--hue', hue);
                        badge.className = 'action-badge action-dynamic';
                        
                        if (!badge.querySelector('.fa-magic')) {
                            let icon = document.createElement('i');
                            icon.className = 'fas fa-magic';
                            icon.style.fontSize = '10px';
                            icon.style.opacity = '0.6';
                            let existingIcon = badge.querySelector('i');
                            if (existingIcon) {
                                existingIcon.after(icon);
                            } else {
                                badge.prepend(icon);
                            }
                        }
                    }
                }
            });
        }

        // ============================================
        // 🎨 DYNAMIC MODULE COLOR ASSIGNMENT
        // ============================================
        function assignModuleColors() {
            const moduleColors = {
                'inventory': 'module-inventory',
                'pos': 'module-pos',
                'categories': 'module-categories',
                'users': 'module-users',
                'profile': 'module-profile',
                'settings': 'module-settings',
                'promos': 'module-promos',
                'discounts': 'module-discounts',
                'auth': 'module-auth',
                'reports': 'module-reports',
                'dashboard': 'module-dashboard',
                'orders': 'module-orders',
                'payments': 'module-payments',
                'returns': 'module-returns',
                'warehouse': 'module-warehouse',
                'suppliers': 'module-suppliers',
                'customers': 'module-customers',
                'employees': 'module-employees',
                'attendance': 'module-attendance',
                'leaves': 'module-leaves',
                'payroll': 'module-payroll',
                'tasks': 'module-tasks',
                'projects': 'module-projects',
                'tickets': 'module-tickets',
                'support': 'module-support',
                'announcements': 'module-announcements',
                'notifications': 'module-notifications'
            };

            document.querySelectorAll('.module-badge').forEach(function(badge, index) {
                let moduleName = badge.getAttribute('data-module') || 
                                badge.textContent.trim().toLowerCase().replace(/\s+/g, '');
                
                let className = moduleColors[moduleName];
                
                if (className) {
                    badge.className = 'module-badge ' + className;
                } else {
                    badge.classList.remove('module-dynamic', 'module-rainbow');
                    
                    if (index % 7 === 0) {
                        badge.className = 'module-badge module-rainbow';
                    } else {
                        let hash = 0;
                        for (let i = 0; i < moduleName.length; i++) {
                            hash = moduleName.charCodeAt(i) + ((hash << 5) - hash);
                        }
                        let hue = Math.abs(hash) % 360;
                        
                        badge.style.setProperty('--hue', hue);
                        badge.className = 'module-badge module-dynamic';
                        
                        if (!badge.querySelector('.fa-magic')) {
                            let icon = document.createElement('i');
                            icon.className = 'fas fa-magic';
                            icon.style.fontSize = '10px';
                            icon.style.opacity = '0.6';
                            let existingIcon = badge.querySelector('i');
                            if (existingIcon) {
                                existingIcon.after(icon);
                            } else {
                                badge.prepend(icon);
                            }
                        }
                    }
                }
            });
        }

        // Run color assignments
        assignActionColors();
        assignModuleColors();

        // ============================================
        // FILTER FUNCTIONALITY - WITH DATE FROM/TO FIX
        // ============================================
        $('#applyFilterBtn').click(function() {
            // ✅ Kunin ang lahat ng filter values
            const startDate = $('#startDate').val();   // Date From
            const endDate = $('#endDate').val();       // Date To
            const action = $('#filterAction').val();
            const module = $('#filterModule').val();
            const userId = $('#filterUser').val();     // User (Admin only)
            const activeTab = "{{ $tab ?? 'personal' }}";

            // ✅ Build URL with all filters included
            let url = "{{ route('activity-logs.index') }}?tab=" + activeTab;
            
            // ✅ Date From - always include if present
            if (startDate) {
                url += "&start_date=" + encodeURIComponent(startDate);
            }
            
            // ✅ Date To - always include if present
            if (endDate) {
                url += "&end_date=" + encodeURIComponent(endDate);
            }
            
            if (action) {
                url += "&action=" + encodeURIComponent(action);
            }
            
            if (module) {
                url += "&module=" + encodeURIComponent(module);
            }
            
            if (userId) {
                url += "&user_id=" + encodeURIComponent(userId);
            }

            // Debug log (optional - pwede tanggalin)
            console.log('Filter URL:', url);

            window.location.href = url;
        });

        // Reset filter: Go back to today
        $('#resetFilterBtn').click(function() {
            const activeTab = "{{ $tab ?? 'personal' }}";
            window.location.href = "{{ route('activity-logs.index') }}?tab=" + activeTab;
        });

        // Enter key support for all filter inputs
        $('#filterUser, #filterAction, #filterModule, #startDate, #endDate').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#applyFilterBtn').click();
            }
        });

        // Auto-apply when date changes (optional, pwede tanggalin)
        $('#startDate, #endDate').on('change', function() {
            // Optional: Auto-apply on date change
            // $('#applyFilterBtn').click();
        });

        // ============================================
        // CLEAR OLD LOGS
        // ============================================
        $('#clearOldBtn').click(function() {
            if (confirm('Are you sure you want to delete activity logs older than 30 days? This action cannot be undone.')) {
                $.ajax({
                    url: "{{ route('activity-logs.clear-old') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message || 'Old logs cleared successfully!');
                            setTimeout(() => window.location.reload(), 1000);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to clear old logs.');
                    }
                });
            }
        });

        // ============================================
        // EXPORT LOGS - WITH DATE FROM/TO FIX
        // ============================================
        $('#exportBtn').click(function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const action = $('#filterAction').val();
            const module = $('#filterModule').val();
            const userId = $('#filterUser').val();
            const activeTab = "{{ $tab ?? 'personal' }}";

            let url = "{{ route('activity-logs.export') }}?tab=" + activeTab;
            
            if (startDate) {
                url += "&start_date=" + encodeURIComponent(startDate);
            }
            if (endDate) {
                url += "&end_date=" + encodeURIComponent(endDate);
            }
            if (action) {
                url += "&action=" + encodeURIComponent(action);
            }
            if (module) {
                url += "&module=" + encodeURIComponent(module);
            }
            if (userId) {
                url += "&user_id=" + encodeURIComponent(userId);
            }

            window.location.href = url;
        });

        // ============================================
        // DESCRIPTION EXPAND
        // ============================================
        document.querySelectorAll('.expand-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                let text = this.closest('.description-box').querySelector('.truncate-text');
                if (text) {
                    if (text.style.webkitLineClamp === 'unset') {
                        text.style.webkitLineClamp = '3';
                        this.textContent = 'Show more';
                    } else {
                        text.style.webkitLineClamp = 'unset';
                        this.textContent = 'Show less';
                    }
                }
            });
        });
    });
</script>

{{-- Toastr notifications --}}
@if(!isset($toastrIncluded))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 4000,
        extendedTimeOut: 1000,
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };
</script>
@php $toastrIncluded = true; @endphp
@endif

@endsection