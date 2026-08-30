<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Pharmacy System')</title>

  <!-- Fonts & Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      background: #edf2f7;
      min-height: 100vh;
      color: #333;
      overflow: hidden;
    }

    /* ==================== SIDEBAR ==================== */
    .sidebar {
      flex-shrink: 0;
      width: 240px;
      background: linear-gradient(180deg, #0b7a33, #056b28);
      color: white;
      display: flex;
      flex-direction: column;
      padding-top: 10px;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      height: 100vh;
      overflow-y: auto;
      overflow-x: hidden;
      z-index: 100;
      transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar::-webkit-scrollbar {
      width: 3px;
    }
    .sidebar::-webkit-scrollbar-track {
      background: #0a6e2e;
    }
    .sidebar::-webkit-scrollbar-thumb {
      background: #ffeb3b;
      border-radius: 4px;
    }

    /* ==================== COLLAPSED STATE - ICON ONLY ==================== */
    .sidebar.collapsed {
      width: 68px;
    }

    .sidebar.collapsed .sidebar-logo h2,
    .sidebar.collapsed .sidebar-label,
    .sidebar.collapsed .sidebar a span,
    .sidebar.collapsed .classification-dropdown span,
    .sidebar.collapsed .classification-submenu a span,
    .sidebar.collapsed .sidebar-footer span {
      display: none !important;
    }

    .sidebar.collapsed .sidebar-logo {
      justify-content: center;
      padding-left: 0;
      gap: 0;
    }

    .sidebar.collapsed .sidebar-logo img {
      width: 38px;
      height: 38px;
    }

    .sidebar.collapsed .sidebar-logo .toggle-icon {
      transform: rotate(180deg);
    }

    .sidebar.collapsed .sidebar a,
    .sidebar.collapsed .classification-dropdown {
      justify-content: center;
      padding: 8px 0;
      margin: 2px 6px;
      border-radius: 10px;
      border-left: none;
      gap: 0;
    }

    .sidebar.collapsed .sidebar a i,
    .sidebar.collapsed .classification-dropdown i:first-child {
      margin: 0;
      font-size: 1.2rem;
      width: auto;
    }

    .sidebar.collapsed .classification-dropdown .fa-caret-down {
      display: none;
    }

    .sidebar.collapsed .classification-submenu {
      margin-left: 0;
    }

    .sidebar.collapsed .classification-submenu a {
      justify-content: center;
      padding: 5px 0;
      margin: 1px 4px;
      border-left: none;
      border-radius: 8px;
      gap: 0;
    }

    .sidebar.collapsed .classification-submenu a i {
      margin: 0;
      font-size: 1rem;
      width: auto;
    }

    .sidebar.collapsed .classification-submenu a span {
      display: none !important;
    }

    .sidebar.collapsed .sidebar-footer {
      display: none;
    }

    /* ==================== SIDEBAR LOGO ==================== */
    .sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      gap: 10px;
      padding: 6px 14px 10px 14px;
      margin-bottom: 10px;
      transition: all 0.3s ease;
      cursor: pointer;
      user-select: none;
      border-radius: 8px;
    }

    .sidebar-logo:hover {
      background: rgba(255, 255, 255, 0.06);
    }

    .sidebar-logo:active {
      transform: scale(0.97);
    }

    .sidebar-logo img {
      width: 34px;
      height: 34px;
      object-fit: contain;
      border-radius: 50%;
      background-color: white;
      padding: 3px;
      flex-shrink: 0;
      transition: all 0.3s ease;
    }

    .sidebar-logo h2 {
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-weight: 700;
      color: #ffffff;
      text-transform: uppercase;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.8), 0 0 20px rgba(255, 255, 255, 0.6), 1px 1px 3px rgba(0, 0, 0, 0.6);
      white-space: nowrap;
      transition: all 0.3s ease;
      flex: 1;
    }

    .sidebar-logo .toggle-icon {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.5);
      transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      flex-shrink: 0;
    }

    /* ==================== SIDEBAR LABELS ==================== */
    .sidebar-label {
      font-size: 9px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: rgba(255, 255, 255, 0.35);
      padding: 14px 14px 6px 14px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
      white-space: nowrap;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    /* ==================== SIDEBAR LINKS ==================== */
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 14px;
      color: rgba(255, 255, 255, 0.85);
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.25s ease;
      border-left: 3px solid transparent;
      border-radius: 0 20px 20px 0;
      margin: 2px 10px;
      background: transparent;
      cursor: pointer;
    }

    .sidebar a i {
      width: 20px;
      font-size: 1rem;
      text-align: center;
      flex-shrink: 0;
      color: rgba(255, 255, 255, 0.6);
      transition: all 0.25s ease;
    }

    .sidebar a span {
      flex: 1;
      white-space: nowrap;
      font-size: 13px;
      transition: all 0.3s ease;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.1);
      border-left-color: #ffeb3b;
      color: #ffffff;
    }

    .sidebar a:hover i {
      color: #ffffff;
    }

    .sidebar a.active {
      background: rgba(255, 255, 255, 0.15);
      border-left-color: #ffeb3b;
      color: #ffffff;
    }

    .sidebar a.active i {
      color: #ffeb3b;
    }

    /* ==================== DROPDOWN (Parent) ==================== */
    .classification-dropdown {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 14px;
      color: rgba(255, 255, 255, 0.85);
      font-size: 13px;
      font-weight: 500;
      transition: all 0.25s ease;
      border-left: 3px solid transparent;
      border-radius: 0 20px 20px 0;
      margin: 2px 10px;
      cursor: pointer;
      background: transparent;
      user-select: none;
    }

    .classification-dropdown i:first-child {
      width: 20px;
      font-size: 1rem;
      text-align: center;
      flex-shrink: 0;
      color: rgba(255, 255, 255, 0.6);
      transition: all 0.25s ease;
    }

    .classification-dropdown span {
      flex: 1;
      white-space: nowrap;
      font-size: 13px;
      transition: all 0.3s ease;
    }

    .classification-dropdown .fa-caret-down {
      margin-left: auto;
      font-size: 12px;
      color: rgba(255, 255, 255, 0.4);
      transition: transform 0.3s ease;
    }

    .classification-dropdown:hover {
      background: rgba(255, 255, 255, 0.1);
      border-left-color: #ffeb3b;
      color: #ffffff;
    }

    .classification-dropdown:hover i:first-child {
      color: #ffffff;
    }

    .classification-dropdown.dropdown-active {
      background: rgba(255, 255, 255, 0.12);
      border-left-color: #ffeb3b;
      color: #ffffff;
    }

    .classification-dropdown.dropdown-active i:first-child {
      color: #ffeb3b;
    }

    .classification-dropdown.dropdown-active .fa-caret-down {
      transform: rotate(180deg);
      color: rgba(255, 255, 255, 0.6);
    }

    /* ==================== SUBMENU ==================== */
    .classification-submenu {
      display: none;
      flex-direction: column;
      padding-left: 0;
      margin-left: 16px;
      background: transparent;
    }

    .classification-submenu.show {
      display: flex !important;
      animation: slideDown 0.2s ease-out;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-5px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .classification-submenu a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 6px 14px 6px 20px;
      margin: 1px 6px 1px 10px;
      font-size: 12px;
      border-left: 2px solid transparent;
      border-radius: 0 16px 16px 0;
      background: rgba(255, 255, 255, 0.04);
      color: rgba(255, 255, 255, 0.75);
    }

    .classification-submenu a i {
      width: 18px;
      font-size: 0.85rem;
      text-align: center;
      flex-shrink: 0;
      color: rgba(255, 255, 255, 0.4);
    }

    .classification-submenu a span {
      font-size: 12px;
    }

    .classification-submenu a:hover {
      background: rgba(255, 255, 255, 0.12);
      border-left-color: #ffeb3b;
      color: #ffffff;
    }

    .classification-submenu a:hover i {
      color: #ffffff;
    }

    .classification-submenu a.active {
      background: rgba(255, 255, 255, 0.15);
      border-left-color: #ffeb3b;
      color: #ffeb3b;
    }

    .classification-submenu a.active i {
      color: #ffeb3b;
    }

    /* ==================== SIDEBAR FOOTER ==================== */
    .sidebar-footer {
      margin-top: auto;
      padding: 12px 14px;
      text-align: center;
      font-size: 10px;
      color: rgba(255, 255, 255, 0.25);
      border-top: 1px solid rgba(255, 255, 255, 0.06);
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    /* ==================== MAIN WRAPPER ==================== */
    .main-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
    }

    /* ==================== HEADER BAR ==================== */
    .header-bar {
      background: white;
      padding: 10px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      flex-shrink: 0;
      border-bottom: 1px solid #e9ecef;
      z-index: 50;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .header-left .breadcrumb {
      margin: 0;
      padding: 0;
      background: transparent;
      font-size: 13px;
    }

    .header-left .breadcrumb-item a {
      color: #0b7a33;
      text-decoration: none;
    }

    .header-left .breadcrumb-item.active {
      color: #6c757d;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .header-right .date-time {
      font-size: 12px;
      color: #6c757d;
    }

    .header-right .date-time i {
      margin-right: 6px;
      color: #0b7a33;
    }

    .header-right .notification-btn {
      position: relative;
      background: none;
      border: none;
      font-size: 18px;
      color: #6c757d;
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 50%;
      transition: all 0.2s;
    }

    .header-right .notification-btn:hover {
      background: #f1f3f5;
      color: #0b7a33;
    }

    .header-right .notification-btn .badge-dot {
      position: absolute;
      top: 2px;
      right: 4px;
      width: 8px;
      height: 8px;
      background: #dc3545;
      border-radius: 50%;
      border: 2px solid white;
    }

    /* ==================== USER DROPDOWN ==================== */
    .user-dropdown-wrapper {
      position: relative;
      display: inline-block;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      padding: 4px 12px 4px 4px;
      border-radius: 30px;
      transition: all 0.2s;
      background: #f8f9fa;
      border: 1px solid #e9ecef;
    }

    .user-profile:hover {
      background: #e9ecef;
    }

    .user-profile .avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #0b7a33;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .user-profile .avatar img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }

    .user-profile .user-info {
      line-height: 1.2;
    }

    .user-profile .user-info .name {
      font-size: 13px;
      font-weight: 600;
      color: #1a1a2e;
    }

    .user-profile .user-info .role {
      font-size: 10px;
      color: #6c757d;
    }

    .user-profile .fa-chevron-down {
      font-size: 10px;
      color: #6c757d;
    }

    .user-dropdown-menu {
      position: absolute;
      top: calc(100% + 8px);
      right: 0;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      min-width: 220px;
      padding: 8px 0;
      display: none;
      border: 1px solid #e9ecef;
      z-index: 9999;
    }

    .user-dropdown-menu.show {
      display: block !important;
    }

    .user-dropdown-menu .dropdown-item {
      padding: 10px 20px;
      font-size: 14px;
      color: #333;
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      transition: all 0.15s;
      cursor: pointer;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
    }

    .user-dropdown-menu .dropdown-item:hover {
      background: #f0f8f0;
      color: #0b7a33;
    }

    .user-dropdown-menu .dropdown-item i {
      width: 20px;
      font-size: 15px;
      color: #6c757d;
    }

    .user-dropdown-menu .dropdown-item:hover i {
      color: #0b7a33;
    }

    .user-dropdown-menu .dropdown-divider {
      height: 1px;
      background: #e9ecef;
      margin: 6px 12px;
    }

    .user-dropdown-menu .dropdown-item.text-danger:hover {
      background: #fce4ec;
      color: #c62828;
    }

    .user-dropdown-menu .dropdown-item.text-danger:hover i {
      color: #c62828;
    }

    .user-dropdown-menu .dropdown-item.text-danger i {
      color: #c62828;
    }

    /* ==================== MAIN CONTENT ==================== */
    .main-content {
      flex: 1;
      padding: 25px 30px;
      background: #edf2f7;
      overflow-y: auto;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .main-content > * {
      animation: fadeInUp 0.35s ease-out;
    }

    /* ==================== LOADING ==================== */
    .page-loading {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.2);
      backdrop-filter: blur(2px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 99999;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.2s ease;
      pointer-events: none;
    }
    .page-loading.active {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }
    .loading-spinner {
      width: 40px;
      height: 40px;
      border: 3px solid #e0e0e0;
      border-top: 3px solid #1b5e20;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        transform: translateX(0);
        z-index: 200;
        height: 100vh;
        width: 260px;
      }

      .sidebar.collapsed {
        transform: translateX(-100%);
        width: 260px;
      }

      .sidebar.collapsed .sidebar-logo h2,
      .sidebar.collapsed .sidebar-label,
      .sidebar.collapsed .sidebar a span,
      .sidebar.collapsed .classification-dropdown span,
      .sidebar.collapsed .classification-submenu a span,
      .sidebar.collapsed .sidebar-footer span {
        display: block !important;
      }

      .sidebar.collapsed .sidebar-logo {
        justify-content: flex-start;
        padding-left: 14px;
        gap: 10px;
      }

      .sidebar.collapsed .sidebar-logo .toggle-icon {
        transform: rotate(180deg);
      }

      .sidebar.collapsed .sidebar a,
      .sidebar.collapsed .classification-dropdown {
        justify-content: flex-start;
        padding: 8px 14px;
        margin: 2px 10px;
        border-left: 3px solid transparent;
        border-radius: 0 20px 20px 0;
        gap: 12px;
      }

      .sidebar.collapsed .sidebar a i,
      .sidebar.collapsed .classification-dropdown i:first-child {
        margin: 0;
        font-size: 1rem;
        width: 20px;
      }

      .sidebar.collapsed .sidebar a span,
      .sidebar.collapsed .classification-dropdown span {
        display: block !important;
        font-size: 13px;
      }

      .sidebar.collapsed .classification-dropdown .fa-caret-down {
        display: block;
      }

      .sidebar.collapsed .classification-submenu {
        margin-left: 16px;
      }

      .sidebar.collapsed .classification-submenu a {
        justify-content: flex-start;
        padding: 6px 14px 6px 20px;
        margin: 1px 6px 1px 10px;
        border-left: 2px solid transparent;
        border-radius: 0 16px 16px 0;
        gap: 12px;
      }

      .sidebar.collapsed .classification-submenu a i {
        width: 18px;
        font-size: 0.85rem;
      }

      .sidebar.collapsed .classification-submenu a span {
        display: block !important;
        font-size: 12px;
      }

      .sidebar.collapsed .sidebar-footer {
        display: block;
      }

      .main-content {
        padding: 15px;
      }

      .header-bar {
        padding: 8px 15px;
      }

      .header-right .date-time {
        display: none;
      }
    }
  </style>

  @php
  use App\Models\Setting;
  @endphp

  @stack('styles')

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

</head>
<body>

<!-- ==================== SIDEBAR ==================== -->
<div class="sidebar" id="sidebar">
  
  <div class="sidebar-logo" id="sidebarLogo">
    @php
        $logo = Setting::get('pharmacy_logo');
    @endphp
    @if($logo && file_exists(storage_path('app/public/' . $logo)))
        <img src="{{ asset('storage/' . $logo) }}" alt="Pharmacy Logo">
    @else
        <img src="{{ asset('logo-pharmacy.jpg') }}" alt="Pharmacy Logo">
    @endif
    <h2>{{ Setting::get('pharmacy_name', 'AERMED') }}</h2>
    <i class="fa-solid fa-chevron-left toggle-icon"></i>
  </div>

  <!-- ==================== MAIN ==================== -->
  <div class="sidebar-label">MAIN</div>

  <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
  </a>

  @can('view pos')
  <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">
    <i class="fa-solid fa-cash-register"></i> <span>POS</span>
  </a>
  @endcan

  <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
    <i class="fa-solid fa-pills"></i> <span>Inventory Management</span>
  </a>

  <!-- ==================== MEDICINE CLASSIFICATION ==================== -->
  @php
      $user = auth()->user();
      $canViewInventory = $user && ($user->can('view inventory') || $user->can('view inventory read only'));
  @endphp

  @if($canViewInventory)
  <div class="sidebar-label">MEDICINE CLASSIFICATION</div>

  @php
      $isClassificationActive = request()->routeIs('categories.*') || 
                                request()->routeIs('dosage-forms.*') ||
                                request()->routeIs('promos.*') ||
                                request()->routeIs('discount-types.*');
  @endphp

  <div class="classification-dropdown {{ $isClassificationActive ? 'dropdown-active' : '' }}" onclick="toggleDropdown('classificationSubmenu', this)">
      <i class="fa-solid fa-layer-group"></i> <span>Medicine Classification</span>
      <i class="fa-solid fa-caret-down"></i>
  </div>

  <div class="classification-submenu {{ $isClassificationActive ? 'show' : '' }}" id="classificationSubmenu">
      <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
          <i class="fa-solid fa-tags"></i> <span>Medicine Categories</span>
      </a>
      <a href="{{ route('dosage-forms.index') }}" class="{{ request()->routeIs('dosage-forms.*') ? 'active' : '' }}">
          <i class="fa-solid fa-prescription-bottle"></i> <span>Dosage Forms</span>
      </a>
      <a href="{{ route('promos.index') }}" class="{{ request()->routeIs('promos.*') ? 'active' : '' }}">
          <i class="fa-solid fa-tags"></i> <span>Promo Management</span>
      </a>
      <a href="{{ route('discount-types.index') }}" class="{{ request()->routeIs('discount-types.*') ? 'active' : '' }}">
          <i class="fa-solid fa-percent"></i> <span>Discount Types</span>
      </a>
  </div>
  @endif

  <!-- ==================== PRESCRIPTIONS ==================== -->
  @php
      $user = auth()->user();
      $canViewPrescriptions = $user && ($user->hasRole('Admin') || $user->hasRole('Pharmacy Assistant') || $user->hasRole('Pharmacist'));
  @endphp

  @if($canViewPrescriptions)
  <div class="sidebar-label">PRESCRIPTIONS</div>

  <a href="{{ route('prescriptions.index') }}" class="{{ request()->routeIs('prescriptions.index') ? 'active' : '' }}">
      <i class="fa-solid fa-prescription-bottle"></i> <span>Prescriptions</span>
  </a>
  @endif

  <!-- ==================== REPORTS ==================== -->
  <div class="sidebar-label">REPORTS</div>

  @php
      $isReportsActive = request()->routeIs('sales-reports.*') || 
                         request()->routeIs('inventory.report') || 
                         request()->routeIs('receipts.*');
  @endphp

  <div class="classification-dropdown {{ $isReportsActive ? 'dropdown-active' : '' }}" onclick="toggleDropdown('reportsSubmenu', this)">
      <i class="fa-solid fa-chart-line"></i> <span>Sales & Reports</span>
      <i class="fa-solid fa-caret-down"></i>
  </div>

  <div class="classification-submenu {{ $isReportsActive ? 'show' : '' }}" id="reportsSubmenu">
      <a href="{{ route('sales-reports.index') }}" class="{{ request()->routeIs('sales-reports.*') ? 'active' : '' }}">
          <i class="fa-solid fa-file-invoice-dollar"></i> <span>Sales Report</span>
      </a>
      <a href="{{ route('inventory.report') }}" class="{{ request()->routeIs('inventory.report') ? 'active' : '' }}">
          <i class="fa-solid fa-boxes"></i> <span>Inventory Report</span>
      </a>
      <a href="{{ route('receipts.index') }}" class="{{ request()->routeIs('receipts.*') ? 'active' : '' }}">
          <i class="fa-solid fa-receipt"></i> <span>Receipt History</span>
      </a>
  </div>

  <!-- ==================== USER MANAGEMENT ==================== -->
  @php
      $user = auth()->user();
      $isAdmin = $user && $user->hasRole('Admin');
  @endphp

  @if($isAdmin || ($user && $user->can('view users')))
  <div class="sidebar-label">USER MANAGEMENT</div>

  @php
      $isUsersActive = request()->routeIs('user-access.*') || 
                       request()->routeIs('users.*') || 
                       request()->routeIs('roles.*');
      $isLogsActive = request()->routeIs('activity-logs.*');
  @endphp

  <div class="classification-dropdown {{ ($isUsersActive || $isLogsActive) ? 'dropdown-active' : '' }}" onclick="toggleDropdown('userManagementSubmenu', this)">
      <i class="fa-solid fa-users-gear"></i> <span>Users</span>
      <i class="fa-solid fa-caret-down"></i>
  </div>

  <div class="classification-submenu {{ ($isUsersActive || $isLogsActive) ? 'show' : '' }}" id="userManagementSubmenu">
      <a href="{{ route('user-access.index') }}" class="{{ $isUsersActive ? 'active' : '' }}">
          <i class="fa-solid fa-users"></i> <span>Users & Roles</span>
      </a>
      <a href="{{ route('activity-logs.index') }}" class="{{ $isLogsActive ? 'active' : '' }}">
          <i class="fa-solid fa-clock-rotate-left"></i> <span>Activity Logs</span>
      </a>
  </div>
  @endif

  <!-- ==================== SETTINGS ==================== -->
  @php $user = auth()->user(); @endphp

  @if($user && ($user->hasRole('Admin') || $user->can('view settings')))
  <div class="sidebar-label">SETTINGS</div>

  @php
      $isSettingsActive = request()->routeIs('settings.*') || request()->routeIs('trusted-devices.*');
  @endphp

  <div class="classification-dropdown {{ $isSettingsActive ? 'dropdown-active' : '' }}" onclick="toggleDropdown('settingsSubmenu', this)">
      <i class="fa-solid fa-gear"></i> <span>Settings</span>
      <i class="fa-solid fa-caret-down"></i>
  </div>

  <div class="classification-submenu {{ $isSettingsActive ? 'show' : '' }}" id="settingsSubmenu">
      @if($user->hasRole('Admin'))
      <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.index') ? 'active' : '' }}">
          <i class="fa-solid fa-store"></i> <span>Pharmacy Information</span>
      </a>
      @endif
      <a href="{{ route('settings.profile') }}" class="{{ request()->routeIs('settings.profile') ? 'active' : '' }}">
          <i class="fa-solid fa-user-circle"></i> <span>My Profile</span>
      </a>
      <!-- ========== ✅ NEW: TRUSTED DEVICES LINK ========== -->
      <a href="{{ route('trusted-devices.index') }}" class="{{ request()->routeIs('trusted-devices.*') ? 'active' : '' }}">
          <i class="fa-solid fa-shield-alt"></i> <span>Trusted Devices</span>
      </a>
  </div>
  @endif

  <!-- ==================== SIDEBAR FOOTER ==================== -->
  <div class="sidebar-footer">
    <span>v1.0.0</span>
  </div>
</div>

<!-- ==================== MAIN WRAPPER ==================== -->
<div class="main-wrapper">

  <!-- ==================== HEADER BAR ==================== -->
  <div class="header-bar">
    <div class="header-left">
      <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggleMobile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          @yield('breadcrumb')
        </ol>
      </nav>
    </div>
    <div class="header-right">
      <div class="date-time">
        <i class="fa-regular fa-calendar"></i>
        {{ now()->format('F d, Y') }}
        <span class="mx-1">|</span>
        <i class="fa-regular fa-clock"></i>
        {{ now()->format('h:i A') }}
      </div>

      <!-- ========== USER DROPDOWN ========== -->
      <div class="user-dropdown-wrapper">
        <div class="user-profile" onclick="toggleUserDropdown(event)">
          <div class="avatar">
            @php
              $user = auth()->user();
              $initial = $user ? strtoupper(substr($user->full_name ?? $user->username, 0, 1)) : 'U';
            @endphp
            @if($user && $user->profile_photo && file_exists(storage_path('app/public/' . $user->profile_photo)))
              <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->full_name ?? $user->username }}">
            @else
              {{ $initial }}
            @endif
          </div>
          <div class="user-info">
            <div class="name">{{ $user ? $user->full_name ?? $user->username : 'Guest' }}</div>
            <div class="role">
                @php
                    $role = $user ? $user->roles->first() : null;
                @endphp
                {{ $role ? $role->name : 'No Role' }}
            </div>
          </div>
          <i class="fa-solid fa-chevron-down"></i>
        </div>

        <div class="user-dropdown-menu" id="userDropdownMenu">
          <a href="{{ route('settings.profile') }}" class="dropdown-item">
            <i class="fa-regular fa-user"></i> My Profile
          </a>
          <a href="{{ route('trusted-devices.index') }}" class="dropdown-item">
            <i class="fa-solid fa-shield-alt"></i> Trusted Devices
          </a>
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="POST" id="headerLogoutForm">
            @csrf
            <button type="submit" class="dropdown-item text-danger" id="headerLogoutBtn">
              <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- ==================== MAIN CONTENT ==================== -->
  <div class="main-content">
    @yield('content')
  </div>

</div>

<!-- ==================== LOADING OVERLAY ==================== -->
<div class="page-loading" id="pageLoading">
  <div class="loading-spinner"></div>
</div>

<script>
  // ==================== SIDEBAR TOGGLE ====================
  const sidebar = document.getElementById('sidebar');
  const sidebarLogo = document.getElementById('sidebarLogo');
  const mobileToggle = document.getElementById('sidebarToggleMobile');

  let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

  if (isSidebarCollapsed) {
    sidebar.classList.add('collapsed');
  }

  // ==================== FORCE HIDE TEXT - ICON ONLY ====================
  function forceHideText() {
    const isCollapsed = sidebar.classList.contains('collapsed');
    const allSpans = document.querySelectorAll('.sidebar a span, .classification-dropdown span, .classification-submenu a span');
    
    allSpans.forEach(span => {
      if (isCollapsed) {
        span.style.display = 'none';
        span.style.visibility = 'hidden';
        span.style.width = '0';
        span.style.height = '0';
        span.style.overflow = 'hidden';
        span.style.fontSize = '0';
        span.style.padding = '0';
        span.style.margin = '0';
        span.style.flex = '0 0 0';
        span.style.minWidth = '0';
        span.style.maxWidth = '0';
        span.style.whiteSpace = 'nowrap';
      } else {
        span.style.display = '';
        span.style.visibility = '';
        span.style.width = '';
        span.style.height = '';
        span.style.overflow = '';
        span.style.fontSize = '';
        span.style.padding = '';
        span.style.margin = '';
        span.style.flex = '';
        span.style.minWidth = '';
        span.style.maxWidth = '';
        span.style.whiteSpace = '';
      }
    });
  }

  // Force hide on page load
  setTimeout(forceHideText, 100);

  function toggleSidebar() {
    isSidebarCollapsed = !isSidebarCollapsed;
    sidebar.classList.toggle('collapsed');
    forceHideText();
    localStorage.setItem('sidebarCollapsed', isSidebarCollapsed ? 'true' : 'false');
  }

  if (sidebarLogo) {
    sidebarLogo.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleSidebar();
    });
  }

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      isSidebarCollapsed = sidebar.classList.contains('collapsed');
      forceHideText();
      localStorage.setItem('sidebarCollapsed', isSidebarCollapsed ? 'true' : 'false');
    });
  }

  // ==================== DROPDOWN TOGGLE ====================
  function toggleDropdown(submenuId, element) {
    event.stopPropagation();
    const submenu = document.getElementById(submenuId);
    if (!submenu) return;
    
    submenu.classList.toggle('show');
    element.classList.toggle('dropdown-active');
  }

  // ==================== USER DROPDOWN ====================
  function toggleUserDropdown(event) {
    event.stopPropagation();
    event.preventDefault();
    const dropdown = document.getElementById('userDropdownMenu');
    if (dropdown) {
      dropdown.classList.toggle('show');
    }
  }

  document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdownMenu');
    const wrapper = document.querySelector('.user-dropdown-wrapper');
    if (dropdown && wrapper && !wrapper.contains(event.target)) {
      dropdown.classList.remove('show');
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const dropdown = document.getElementById('userDropdownMenu');
      if (dropdown) {
        dropdown.classList.remove('show');
      }
    }
  });

  // ==================== AUTO OPEN DROPDOWNS ====================
  document.addEventListener('DOMContentLoaded', function() {
    const path = window.location.pathname;
    
    // Medicine Classification
    if (path.includes('/categories') || path.includes('/dosage-forms') || 
        path.includes('/promos') || path.includes('/discount-types')) {
      const submenu = document.getElementById('classificationSubmenu');
      const dropdown = document.querySelector('.classification-dropdown:has(.fa-classification)');
      if (submenu && dropdown && !submenu.classList.contains('show')) {
        submenu.classList.add('show');
        dropdown.classList.add('dropdown-active');
      }
    }
    
    // Prescriptions
    if (path.includes('/prescriptions')) {
      const submenu = document.getElementById('prescriptionsSubmenu');
      const dropdown = document.querySelector('.classification-dropdown:has(.fa-prescription-bottle)');
      if (submenu && dropdown && !submenu.classList.contains('show')) {
        submenu.classList.add('show');
        dropdown.classList.add('dropdown-active');
      }
    }

    // Reports
    if (path.includes('/sales-reports') || path.includes('/inventory/report') || 
        path.includes('/receipts')) {
      const submenu = document.getElementById('reportsSubmenu');
      const dropdown = document.querySelector('.classification-dropdown:has(.fa-chart-line)');
      if (submenu && dropdown && !submenu.classList.contains('show')) {
        submenu.classList.add('show');
        dropdown.classList.add('dropdown-active');
      }
    }

    // User Management
    if (path.includes('/user-access') || path.includes('/users') || 
        path.includes('/roles') || path.includes('/activity-logs')) {
      const submenu = document.getElementById('userManagementSubmenu');
      const dropdown = document.querySelector('.classification-dropdown:has(.fa-users-gear)');
      if (submenu && dropdown && !submenu.classList.contains('show')) {
        submenu.classList.add('show');
        dropdown.classList.add('dropdown-active');
      }
    }
    
    // Settings
    if (path.includes('/settings') || path.includes('/trusted-devices')) {
      const submenu = document.getElementById('settingsSubmenu');
      const dropdown = document.querySelector('.classification-dropdown:has(.fa-gear)');
      if (submenu && dropdown && !submenu.classList.contains('show')) {
        submenu.classList.add('show');
        dropdown.classList.add('dropdown-active');
      }
    }
    
    // Force hide text after DOM loaded
    setTimeout(forceHideText, 200);
  });

  // ==================== PAGE TRANSITION ====================
  document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('pageLoading');
    
    const allNavLinks = document.querySelectorAll('.sidebar a, .classification-submenu a, .dropdown-item');
    allNavLinks.forEach(link => {
      const href = link.getAttribute('href');
      if (!href || href === '#' || href.startsWith('javascript:') || link.classList.contains('disabled-link')) {
        return;
      }
      link.addEventListener('click', function(e) {
        if (link.getAttribute('onclick') && link.getAttribute('onclick') !== 'return false;') return;
        if (link.closest('.user-dropdown-menu')) return;
        e.preventDefault();
        loadingOverlay.classList.add('active');
        setTimeout(() => {
          window.location.href = href;
        }, 180);
      });
    });
    
    window.addEventListener('load', function() {
      setTimeout(() => {
        loadingOverlay.classList.remove('active');
      }, 100);
    });
  });

  // ==================== LOGOUT ====================
  document.addEventListener('DOMContentLoaded', function() {
    const headerLogoutBtn = document.getElementById('headerLogoutBtn');
    if (headerLogoutBtn) {
      headerLogoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: "You will be logged out of your session.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0b7a33',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, logout!',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('headerLogoutForm').submit();
          }
        });
      });
    }
  });

  document.querySelectorAll('.classification-dropdown').forEach(div => {
    div.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });
</script>

@stack('scripts')

</body>
</html>