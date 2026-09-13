@extends('layouts.app')

@section('title', 'Create Prescription')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ============================================
       🎯 CREATE PRESCRIPTION - PLAIN OVERLAY
       ============================================ */

    .prescription-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.55);
        z-index: 99998;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .prescription-modal {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 1100px;
        max-height: 92vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
        overflow: hidden;
        position: relative;
        z-index: 99999;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 18px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .modal-header-custom h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-close-btn {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s;
        position: relative;
        z-index: 100000;
        text-decoration: none;
    }

    .modal-close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
        color: white;
    }

    .modal-body-custom {
        padding: 20px 25px;
        overflow-y: auto;
        flex: 1;
        background: #f8f9fa;
    }

    .modal-body-custom::-webkit-scrollbar { width: 6px; }
    .modal-body-custom::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .modal-body-custom::-webkit-scrollbar-thumb { background: #0b7a33; border-radius: 4px; }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-card {
        background: white;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .form-card-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .form-card-body {
        padding: 15px 18px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        font-size: 12px;
        display: block;
    }

    .form-label .required {
        color: #dc3545;
        margin-left: 2px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s;
        height: 38px;
        width: 100%;
        background: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #adb5bd;
        font-size: 12px;
    }

    textarea.form-control {
        height: auto;
        min-height: 60px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }

    .searchable-select {
        position: relative;
        width: 100%;
    }

    .searchable-select-input {
        width: 100%;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        padding: 8px 35px 8px 12px;
        font-size: 13px;
        height: 38px;
        background: #fff;
        cursor: text;
        transition: all 0.3s;
    }

    .searchable-select-input:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .searchable-select-arrow {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #999;
        font-size: 12px;
        transition: transform 0.3s;
    }

    .searchable-select.open .searchable-select-arrow {
        transform: translateY(-50%) rotate(180deg);
    }

    .searchable-select-list {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        max-height: 250px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .searchable-select.open .searchable-select-list {
        display: block;
    }

    .searchable-select-list::-webkit-scrollbar { width: 6px; }
    .searchable-select-list::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .searchable-select-list::-webkit-scrollbar-thumb { background: #0b7a33; border-radius: 4px; }

    .searchable-select-option {
        padding: 9px 14px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.2s;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .searchable-select-option:last-child { border-bottom: none; }
    .searchable-select-option:hover,
    .searchable-select-option.highlighted { background: #e8f5e9; }
    .searchable-select-option.selected { background: #c8e6c9; font-weight: 600; }

    .searchable-select-option .option-name {
        flex: 1;
        font-weight: 500;
        color: #333;
    }

    .searchable-select-option .option-details {
        font-size: 11px;
        color: #999;
        white-space: nowrap;
    }

    .searchable-select-option.no-results {
        color: #999;
        text-align: center;
        padding: 15px;
        font-style: italic;
        cursor: default;
    }

    .medication-item {
        background: #f8fdf8;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .medication-item:hover {
        border-color: #0b7a33;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .medication-item:last-child { margin-bottom: 0; }
    .medication-item.new-item { animation: slideIn 0.3s ease; }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .item-number {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #0b7a33;
        color: white;
        border-radius: 20px;
        padding: 3px 14px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .remove-item-btn {
        background: #ffebee;
        color: #c62828;
        border: none;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .remove-item-btn:hover {
        background: #c62828;
        color: white;
        transform: scale(1.02);
    }

    .auto-info-box {
        background: #e8f5e9;
        border-left: 4px solid #0b7a33;
        padding: 10px 14px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 12px;
        color: #1b5e20;
        display: none;
    }

    .auto-info-box.show { display: block; animation: slideIn 0.3s ease; }

    .auto-info-box .info-row {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
        border-bottom: 1px dashed #c8e6c9;
    }

    .auto-info-box .info-row:last-child { border-bottom: none; }
    .auto-info-box .info-label { font-weight: 600; color: #2e7d32; }
    .auto-info-box .info-value { font-weight: 700; color: #1b5e20; }

    .btn-add-item {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-item:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .modal-footer-custom {
        padding: 15px 25px;
        background: white;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-shrink: 0;
        flex-wrap: wrap;
        position: relative;
        z-index: 100000;
    }

    .btn-save {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 30px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        z-index: 100001;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(11, 122, 51, 0.4);
    }

    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 30px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        position: relative;
        z-index: 100001;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    .info-box {
        background: #e3f2fd;
        border-left: 4px solid #1976d2;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 12px;
        color: #0d47a1;
    }

    .info-box i { margin-right: 6px; }

    @media (max-width: 992px) {
        .form-grid-2 { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .prescription-modal { max-width: 100%; max-height: 95vh; }
        .modal-header-custom { padding: 14px 18px; }
        .modal-header-custom h2 { font-size: 16px; }
        .modal-body-custom { padding: 15px; }
        .form-row, .form-row-3 { grid-template-columns: 1fr; }
        .modal-footer-custom { flex-direction: column-reverse; padding: 12px 15px; }
        .btn-save, .btn-cancel { width: 100%; justify-content: center; }
    }

    @media (max-width: 576px) {
        .modal-header-custom h2 { font-size: 14px; }
        .form-label { font-size: 11px; }
        .form-control, .form-select, .searchable-select-input {
            font-size: 12px;
            padding: 6px 10px;
            height: 36px;
        }
        .medication-item { padding: 12px; }
    }
</style>

<!-- ===== OVERLAY MODAL ===== -->
<div class="prescription-overlay" id="prescriptionOverlay">
    <div class="prescription-modal">
        
        <!-- ===== MODAL HEADER ===== -->
        <div class="modal-header-custom">
            <h2>
                <i class="fas fa-prescription-bottle"></i>
                Create Prescription
            </h2>
            <a href="{{ route('prescriptions.index') }}" class="modal-close-btn" title="Close">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <!-- ===== MODAL BODY ===== -->
        <div class="modal-body-custom">
            
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                Fill out all required fields. Fields marked with <span style="color: #dc3545;">*</span> are required.
            </div>

            <form id="prescriptionForm" action="{{ route('prescriptions.store') }}" method="POST">
                @csrf

                <div class="form-grid-2">
                    <!-- Patient Information -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <span><i class="fas fa-user-circle"></i> Patient Information</span>
                        </div>
                        <div class="form-card-body">
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Full Name <span class="required">*</span></label>
                                <input type="text" name="patient_name" class="form-control" 
                                       placeholder="Enter patient's full name" required>
                            </div>
                            <div class="form-row">
                                <div>
                                    <label class="form-label">Age (years)</label>
                                    <input type="number" name="patient_age" class="form-control" 
                                           placeholder="e.g., 25" min="0">
                                </div>
                                <div>
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="patient_contact" class="form-control" 
                                           placeholder="e.g., 09123456789">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Complete Address</label>
                                <textarea name="patient_address" class="form-control" rows="2" 
                                          placeholder="House number, Street, Barangay, City"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Information -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <span><i class="fas fa-stethoscope"></i> Doctor Information</span>
                        </div>
                        <div class="form-card-body">
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">Doctor's Full Name <span class="required">*</span></label>
                                <input type="text" name="doctor_name" class="form-control" 
                                       placeholder="Enter doctor's full name" required>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <label class="form-label">PRC License Number</label>
                                <input type="text" name="doctor_license" class="form-control" 
                                       placeholder="e.g., 123456">
                            </div>
                            <div class="form-row">
                                <div>
                                    <label class="form-label">Date Issued <span class="required">*</span></label>
                                    <input type="date" name="date_issued" class="form-control" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Valid Until</label>
                                    <input type="date" name="valid_until" class="form-control" 
                                           value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <span><i class="fas fa-comment-medical"></i> Special Instructions</span>
                    </div>
                    <div class="form-card-body">
                        <textarea name="special_instructions" class="form-control" rows="2" 
                                  placeholder="e.g., Take with food, Avoid alcohol, Refrain from driving, etc."></textarea>
                    </div>
                </div>

                <div class="form-card">
                    <div class="form-card-header">
                        <span><i class="fas fa-tablets"></i> Medication List</span>
                        <button type="button" id="addItemBtn" class="btn-add-item">
                            <i class="fas fa-plus-circle"></i> Add Medication
                        </button>
                    </div>
                    <div class="form-card-body" style="background: #f8f9fa;">
                        <div id="itemsContainer">
                            <div class="medication-item" data-item-index="0">
                                <div class="item-header">
                                    <span class="item-number"><i class="fas fa-pills"></i> Item #1</span>
                                    <button type="button" class="remove-item-btn">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </div>

                                <div style="margin-bottom: 12px;">
                                    <label class="form-label">Medicine <span class="required">*</span></label>
                                    <div class="searchable-select" data-index="0">
                                        <input type="text" 
                                               class="searchable-select-input" 
                                               placeholder="🔍 Type to search medicine..."
                                               autocomplete="off"
                                               data-index="0">
                                        <span class="searchable-select-arrow">▼</span>
                                        <div class="searchable-select-list" data-list="0">
                                            @foreach($products as $product)
                                            <div class="searchable-select-option" 
                                                 data-value="{{ $product->id }}"
                                                 data-name="{{ $product->name }}"
                                                 data-dosage="{{ $product->dosage_amount }} {{ $product->dosage_unit }}"
                                                 data-type="{{ $product->type }}"
                                                 data-brand="{{ $product->brand }}"
                                                 data-price="{{ $product->price }}"
                                                 data-stock="{{ $product->total_pieces_left ?? 0 }}"
                                                 data-search="{{ strtolower($product->name . ' ' . $product->brand . ' ' . $product->dosage_amount . $product->dosage_unit . ' ' . $product->type) }}">
                                                <span class="option-name">{{ $product->name }} @if($product->brand)({{ $product->brand }})@endif</span>
                                                <span class="option-details">{{ $product->dosage_amount }}{{ $product->dosage_unit }} • {{ $product->type }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="items[0][product_id]" class="medicine-value" value="">
                                    </div>
                                </div>

                                <div class="auto-info-box" id="info-0">
                                    <div class="info-row">
                                        <span class="info-label">Type:</span>
                                        <span class="info-value" id="type-0">—</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Brand:</span>
                                        <span class="info-value" id="brand-0">—</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Dosage:</span>
                                        <span class="info-value" id="dosage-0">—</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Stock Available:</span>
                                        <span class="info-value" id="stock-0">—</span>
                                    </div>
                                </div>

                                <div class="form-row-3" style="margin-top: 12px;">
                                    <div>
                                        <label class="form-label">Quantity <span class="required">*</span></label>
                                        <input type="number" name="items[0][quantity]" class="form-control quantity-input" 
                                               placeholder="No. of pieces" required min="1" data-index="0">
                                        <small class="stock-warning" id="warning-0" style="color: #dc3545; font-size: 11px; display: none;"></small>
                                    </div>
                                    <div>
                                        <label class="form-label">Frequency</label>
                                        <input type="text" name="items[0][frequency]" class="form-control" 
                                               placeholder="e.g., 3x/day">
                                    </div>
                                    <div>
                                        <label class="form-label">Duration</label>
                                        <input type="text" name="items[0][duration]" class="form-control" 
                                               placeholder="e.g., 7 days">
                                    </div>
                                </div>

                                <div style="margin-top: 12px;">
                                    <label class="form-label">Special Note (Optional)</label>
                                    <input type="text" name="items[0][special_note]" class="form-control" 
                                           placeholder="e.g., Take before bedtime, With meals, etc.">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== MODAL FOOTER ===== -->
        <div class="modal-footer-custom">
            <a href="{{ route('prescriptions.index') }}" class="btn-cancel">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
            <button type="submit" form="prescriptionForm" class="btn-save" id="submitBtn">
                <i class="fas fa-save"></i> Save Prescription
            </button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let itemCount = 1;

    // ============================================
    // ESC KEY - Redirect sa Index
    // ============================================
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            if ($('.searchable-select.open').length > 0) {
                $('.searchable-select').removeClass('open');
                return;
            }
            window.location.href = '{{ route("prescriptions.index") }}';
        }
    });

    // ============================================
    // SEARCHABLE DROPDOWN
    // ============================================
    $(document).on('focus click', '.searchable-select-input', function(e) {
        e.stopPropagation();
        $('.searchable-select').not($(this).closest('.searchable-select')).removeClass('open');
        $(this).closest('.searchable-select').addClass('open');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.searchable-select').length) {
            $('.searchable-select').removeClass('open');
        }
    });

    $(document).on('input', '.searchable-select-input', function() {
        const search = $(this).val().toLowerCase().trim();
        const $select = $(this).closest('.searchable-select');
        const $list = $select.find('.searchable-select-list');
        const $options = $list.find('.searchable-select-option');
        
        let visibleCount = 0;
        
        $options.each(function() {
            const searchData = $(this).data('search') || '';
            if (search === '' || searchData.includes(search)) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });
        
        let $noResults = $list.find('.no-results');
        if (visibleCount === 0) {
            if ($noResults.length === 0) {
                $list.append('<div class="searchable-select-option no-results">No medicines found</div>');
            }
        } else {
            $noResults.remove();
        }
    });

    $(document).on('click', '.searchable-select-option:not(.no-results)', function() {
        const $option = $(this);
        const $select = $option.closest('.searchable-select');
        const $input = $select.find('.searchable-select-input');
        const $hidden = $select.find('.medicine-value');
        const index = $select.data('index');
        
        const value = $option.data('value');
        const name = $option.data('name');
        const dosage = $option.data('dosage');
        const type = $option.data('type');
        const brand = $option.data('brand');
        const stock = $option.data('stock');
        
        $input.val(name + (brand ? ' (' + brand + ')' : ''));
        $hidden.val(value);
        
        $select.find('.searchable-select-option').removeClass('selected');
        $option.addClass('selected');
        $select.removeClass('open');
        
        $('#type-' + index).text(type || 'N/A');
        $('#brand-' + index).text(brand || 'N/A');
        $('#dosage-' + index).text(dosage || 'N/A');
        $('#stock-' + index).text(stock + ' pcs');
        $('#info-' + index).addClass('show');
        
        checkStock(index, stock);
    });

    $(document).on('input', '.quantity-input', function() {
        const index = $(this).data('index');
        const stock = parseInt($('#stock-' + index).text()) || 0;
        checkStock(index, stock);
    });

    function checkStock(index, stock) {
        const $warning = $('#warning-' + index);
        const qty = parseInt($('input[name="items[' + index + '][quantity]"]').val()) || 0;
        
        if (stock > 0 && qty > stock) {
            $warning.text(`⚠️ Only ${stock} pcs available in stock!`).show();
        } else {
            $warning.hide();
        }
    }

    // ============================================
    // ADD NEW MEDICATION ITEM
    // ============================================
    $('#addItemBtn').click(function() {
        const newIndex = itemCount;
        
        let optionsHtml = '';
        @foreach($products as $product)
        optionsHtml += `
            <div class="searchable-select-option" 
                 data-value="{{ $product->id }}"
                 data-name="{{ $product->name }}"
                 data-dosage="{{ $product->dosage_amount }} {{ $product->dosage_unit }}"
                 data-type="{{ $product->type }}"
                 data-brand="{{ $product->brand }}"
                 data-price="{{ $product->price }}"
                 data-stock="{{ $product->total_pieces_left ?? 0 }}"
                 data-search="{{ strtolower($product->name . ' ' . $product->brand . ' ' . $product->dosage_amount . $product->dosage_unit . ' ' . $product->type) }}">
                <span class="option-name">{{ $product->name }} @if($product->brand)({{ $product->brand }})@endif</span>
                <span class="option-details">{{ $product->dosage_amount }}{{ $product->dosage_unit }} • {{ $product->type }}</span>
            </div>
        `;
        @endforeach
        
        const newItem = `
            <div class="medication-item new-item" data-item-index="${newIndex}">
                <div class="item-header">
                    <span class="item-number"><i class="fas fa-pills"></i> Item #${newIndex + 1}</span>
                    <button type="button" class="remove-item-btn">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>
                </div>
                <div style="margin-bottom: 12px;">
                    <label class="form-label">Medicine <span class="required">*</span></label>
                    <div class="searchable-select" data-index="${newIndex}">
                        <input type="text" 
                               class="searchable-select-input" 
                               placeholder="🔍 Type to search medicine..."
                               autocomplete="off"
                               data-index="${newIndex}">
                        <span class="searchable-select-arrow">▼</span>
                        <div class="searchable-select-list" data-list="${newIndex}">
                            ${optionsHtml}
                        </div>
                        <input type="hidden" name="items[${newIndex}][product_id]" class="medicine-value" value="">
                    </div>
                </div>
                <div class="auto-info-box" id="info-${newIndex}">
                    <div class="info-row">
                        <span class="info-label">Type:</span>
                        <span class="info-value" id="type-${newIndex}">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Brand:</span>
                        <span class="info-value" id="brand-${newIndex}">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dosage:</span>
                        <span class="info-value" id="dosage-${newIndex}">—</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Stock Available:</span>
                        <span class="info-value" id="stock-${newIndex}">—</span>
                    </div>
                </div>
                <div class="form-row-3" style="margin-top: 12px;">
                    <div>
                        <label class="form-label">Quantity <span class="required">*</span></label>
                        <input type="number" name="items[${newIndex}][quantity]" class="form-control quantity-input" 
                               placeholder="No. of pieces" required min="1" data-index="${newIndex}">
                        <small class="stock-warning" id="warning-${newIndex}" style="color: #dc3545; font-size: 11px; display: none;"></small>
                    </div>
                    <div>
                        <label class="form-label">Frequency</label>
                        <input type="text" name="items[${newIndex}][frequency]" class="form-control" 
                               placeholder="e.g., 3x/day">
                    </div>
                    <div>
                        <label class="form-label">Duration</label>
                        <input type="text" name="items[${newIndex}][duration]" class="form-control" 
                               placeholder="e.g., 7 days">
                    </div>
                </div>
                <div style="margin-top: 12px;">
                    <label class="form-label">Special Note (Optional)</label>
                    <input type="text" name="items[${newIndex}][special_note]" class="form-control" 
                           placeholder="e.g., Take before bedtime, With meals, etc.">
                </div>
            </div>
        `;
        $('#itemsContainer').append(newItem);
        itemCount++;

        setTimeout(() => {
            $('.modal-body-custom').animate({
                scrollTop: $('.modal-body-custom').scrollTop() + $('.medication-item:last').position().top - 100
            }, 500);
        }, 100);
    });

    // ============================================
    // REMOVE MEDICATION ITEM
    // ============================================
    $(document).on('click', '.remove-item-btn', function() {
        if ($('.medication-item').length > 1) {
            $(this).closest('.medication-item').remove();

            $('.medication-item').each(function(index) {
                $(this).find('.item-number').html(`<i class="fas fa-pills"></i> Item #${index + 1}`);
                $(this).attr('data-item-index', index);

                $(this).find('input, select, textarea').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        name = name.replace(/items\[\d+\]/, `items[${index}]`);
                        $(this).attr('name', name);
                    }
                });
                
                $(this).find('[data-index]').attr('data-index', index);
                $(this).find('.searchable-select').attr('data-index', index);
                
                $(this).find('[id^="type-"], [id^="brand-"], [id^="dosage-"], [id^="stock-"], [id^="warning-"], [id^="info-"]').each(function() {
                    const oldId = $(this).attr('id');
                    const newId = oldId.replace(/-\d+$/, `-${index}`);
                    $(this).attr('id', newId);
                });
            });

            itemCount = $('.medication-item').length;
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Cannot Remove',
                text: 'At least one medication is required.',
                confirmButtonColor: '#0b7a33'
            });
        }
    });

    // ============================================
    // AUTO-SET VALID UNTIL
    // ============================================
    $('input[name="date_issued"]').on('change', function() {
        let dateIssued = $(this).val();
        if (dateIssued) {
            let newDate = new Date(dateIssued);
            newDate.setDate(newDate.getDate() + 30);
            let year = newDate.getFullYear();
            let month = String(newDate.getMonth() + 1).padStart(2, '0');
            let day = String(newDate.getDate()).padStart(2, '0');
            $('input[name="valid_until"]').val(`${year}-${month}-${day}`);
        }
    });

    // ============================================
    // ✅ FORM SUBMISSION → SUCCESS NOTIFICATION
    // ============================================
    $('#prescriptionForm').on('submit', function(e) {
        e.preventDefault();

        let hasError = false;
        $('.medicine-value').each(function() {
            if (!$(this).val()) {
                hasError = true;
                $(this).closest('.searchable-select').find('.searchable-select-input').css('border-color', '#dc3545');
            } else {
                $(this).closest('.searchable-select').find('.searchable-select-input').css('border-color', '#e0e0e0');
            }
        });

        if (hasError) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Medicine',
                text: 'Please select a medicine for each item.',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        let form = $(this);
        let formData = new FormData(this);
        let submitBtn = $('#submitBtn');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        Swal.fire({
            title: 'Saving Prescription...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',           // ✅ IDINAGDAG
                'X-Requested-With': 'XMLHttpRequest'    // ✅ IDINAGDAG
            },
            success: function(response) {
                if (response.success || response.status === 'success') {
                    // ✅ SUCCESS NOTIFICATION
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Prescription Created!',
                        html: `
                            <div style="text-align: left; padding: 10px;">
                                <p style="font-size: 15px; margin-bottom: 8px;">
                                    <strong>RX #:</strong> ${response.prescription_number || 'N/A'}
                                </p>
                                <p style="font-size: 14px; color: #666; margin-bottom: 8px;">
                                    <strong>Patient:</strong> ${response.patient_name || 'N/A'}
                                </p>
                                <hr style="margin: 10px 0;">
                                <p style="font-size: 14px; color: #0b7a33; font-weight: 600;">
                                    ✅ Prescription saved successfully!
                                </p>
                            </div>
                        `,
                        confirmButtonText: '👌 OK',
                        confirmButtonColor: '#0b7a33',
                        timer: 2500,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Error',
                        text: response.message || 'Failed to save prescription.',
                        confirmButtonColor: '#dc3545'
                    });
                    submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Prescription');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong. Please try again.';

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = '<ul style="text-align: left; margin: 0; padding-left: 20px;">';
                    for (let key in xhr.responseJSON.errors) {
                        errorMsg += '<li><i class="fas fa-exclamation-circle" style="color: #dc3545;"></i> ' + xhr.responseJSON.errors[key][0] + '</li>';
                    }
                    errorMsg += '</ul>';

                    Swal.fire({
                        icon: 'error',
                        title: '⚠️ Validation Error',
                        html: errorMsg,
                        confirmButtonText: 'Got it!',
                        confirmButtonColor: '#dc3545'
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Error!',
                        text: xhr.responseJSON.message,
                        confirmButtonColor: '#dc3545'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Oops!',
                        text: errorMsg,
                        confirmButtonColor: '#dc3545'
                    });
                }

                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save Prescription');
            }
        });
    });
</script>

@endsection