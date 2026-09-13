@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - EDIT PRODUCT
       ============================================ */

    /* ===== HEADER BOX ===== */
    .header-box {
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 12px;
        padding: 20px 30px;
        margin-bottom: 30px;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .header-box .btn-back {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .header-box .btn-back:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    /* ===== FORM CARD ===== */
    .form-card {
        background: #ffffff;
        padding: 25px 30px;
        border-radius: 12px;
        max-width: 750px;
        margin: 0 auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #eef2f6;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        flex-wrap: wrap;
    }

    .form-label .required {
        color: #dc3545;
        font-weight: 700;
    }

    .form-label .current-value {
        font-weight: 400;
        color: #6c757d;
        font-size: 11px;
        background: #f8f9fa;
        padding: 2px 10px;
        border-radius: 12px;
    }

    .form-label .badge-auto {
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 9px;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .form-control {
        width: 100%;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        transition: all 0.3s ease;
        font-size: 13px;
        background-color: white;
        height: 38px;
    }

    .form-control:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-valid {
        border-color: #28a745;
    }

    .form-control:disabled {
        background: #f8f9fa;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .form-control[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        display: none;
        align-items: center;
        gap: 6px;
    }

    .invalid-feedback.show {
        display: flex;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
        display: block;
    }

    /* ===== FORM ROWS ===== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    /* ===== UNIT DISPLAY ===== */
    .unit-display {
        background: #f8f9fa;
        padding: 6px 14px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        min-height: 38px;
        display: flex;
        align-items: center;
        font-size: 13px;
    }

    .unit-display .unit-value {
        font-weight: 700;
        color: #0b7a33;
        margin-left: 4px;
    }

    .unit-display .no-unit {
        color: #999;
        font-style: italic;
    }

    .unit-display i {
        color: #0b7a33;
        font-size: 13px;
        margin-right: 8px;
    }

    /* ===== BARCODE ===== */
    .barcode-box {
        background: #f8f9fa;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 16px;
        border: 1px solid #e9ecef;
    }

    .barcode-box .form-group {
        margin-bottom: 0;
    }

    .barcode-wrapper {
        display: flex;
        gap: 10px;
    }

    .barcode-wrapper .form-control {
        flex: 1;
        font-family: monospace;
        letter-spacing: 1px;
    }

    .barcode-wrapper .btn-generate {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0 18px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
        font-size: 13px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .barcode-wrapper .btn-generate:hover {
        background: #5a6268;
        transform: translateY(-1px);
    }

    .barcode-preview {
        text-align: center;
        padding: 8px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        margin-top: 8px;
    }

    .barcode-preview img {
        height: 45px;
        border: 1px solid #ddd;
        padding: 4px;
        border-radius: 4px;
        background: white;
    }

    /* ===== STOCK INFO ===== */
    .stock-info-box {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        padding: 6px 14px;
        border-radius: 8px;
        text-align: center;
        border: 1.5px solid #0b7a33;
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #0b7a33;
        font-size: 13px;
    }

    .calculated-field {
        background: #e8f5e9 !important;
        border: 1.5px solid #0b7a33 !important;
        font-weight: 700;
        color: #0b7a33 !important;
    }

    /* ===== IMAGE PREVIEW ===== */
    .image-preview-container {
        margin-top: 8px;
        position: relative;
        display: inline-block;
    }

    .image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 4px;
        background: white;
    }

    .image-preview-container .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .image-preview-container .remove-image:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }

    /* ===== BATCH INFO ===== */
    .batch-info-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px 16px;
        border: 1px solid #e9ecef;
        margin-bottom: 16px;
    }

    .batch-info-box .batch-label {
        font-size: 11px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .batch-info-box .batch-value {
        font-size: 15px;
        font-weight: 700;
        color: #0b7a33;
        margin-top: 2px;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }

    .status-available { background: #e8f5e9; color: #2e7d32; }
    .status-lowstock { background: #fff3e0; color: #e65100; }
    .status-expired { background: #ffebee; color: #c62828; }
    .status-nearexpired { background: #fff8e1; color: #f57f17; }

    /* ===== INFO BADGE ===== */
    .info-badge {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 10px 16px;
        border-left: 4px solid #0b7a33;
        margin-bottom: 20px;
        font-size: 13px;
        color: #0b7a33;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-badge i {
        font-size: 16px;
    }

    /* ===== BUTTONS ===== */
    .btn-group-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 2px dashed #e9ecef;
    }

    .btn-save {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 10px 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        font-size: 14px;
        box-shadow: 0 2px 8px rgba(11, 122, 51, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(11, 122, 51, 0.4);
    }

    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        padding: 10px 32px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        flex: 1;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-box {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
        }
        .header-box h2 {
            font-size: 20px;
        }
        .header-box .btn-back {
            width: 100%;
            justify-content: center;
        }
        .form-card {
            padding: 16px;
            margin: 0 5px;
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
            justify-content: center;
        }
        .btn-group-actions {
            flex-direction: column;
        }
        .form-label {
            font-size: 12px;
        }
        .form-label .current-value {
            font-size: 10px;
        }
        .batch-info-box .batch-value {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .form-control {
            font-size: 12px;
            padding: 6px 10px;
            height: 34px;
        }
        .btn-save,
        .btn-cancel {
            font-size: 13px;
            padding: 8px 20px;
        }
        .image-preview {
            width: 80px;
            height: 80px;
        }
        .stock-info-box {
            font-size: 12px;
            min-height: 34px;
        }
        .unit-display {
            font-size: 12px;
            min-height: 34px;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-edit"></i>
            Edit Product
        </h2>
        <a href="{{ route('inventory.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Inventory
        </a>
    </div>

    <!-- ===== FORM CARD ===== -->
    <div class="form-card">
        <!-- Info Badge -->
        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            <span><strong>Note:</strong> Only update the fields you want to change. Empty fields will keep their original values.</span>
        </div>

        <form id="editForm" action="{{ route('inventory.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="batch_id" value="{{ $batch->id ?? '' }}">

            <!-- ===== PRODUCT NAME ===== -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-signature"></i> Product Name
                    <span class="required">*</span>
                    <span class="current-value">Current: {{ $product->name }}</span>
                </label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $product->name) }}" required>
                <div class="invalid-feedback" id="nameError">
                    <i class="fas fa-exclamation-circle"></i> Product Name is required.
                </div>
            </div>

            <!-- ===== BARCODE ===== -->
            <div class="barcode-box">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-barcode"></i> Barcode
                        <span class="current-value">Current: {{ $product->barcode ?? 'None' }}</span>
                    </label>
                    <div class="barcode-wrapper">
                        <input type="text" name="barcode" id="barcode" class="form-control" 
                               value="{{ old('barcode', $product->barcode) }}" placeholder="Scan or type barcode...">
                        <button type="button" id="generateBarcodeBtn" class="btn-generate">
                            <i class="fas fa-sync-alt"></i> Generate
                        </button>
                    </div>
                    <span class="form-text">Leave blank to keep existing barcode</span>
                </div>
                <div id="barcodePreview" style="display: none; text-align: center; margin-top: 6px;">
                    <div class="barcode-preview">
                        <div id="previewImage"></div>
                    </div>
                </div>
            </div>

            <!-- ===== BRAND ===== -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-trademark"></i> Brand
                    <span class="current-value">Current: {{ $product->brand ?? 'None' }}</span>
                </label>
                <input type="text" name="brand" id="brand" class="form-control" 
                       value="{{ old('brand', $product->brand) }}" placeholder="e.g., Unilab">
            </div>

            <!-- ===== DOSAGE ===== -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-weight-scale"></i> Dosage Amount
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $product->dosage_amount ?? 0 }}</span>
                    </label>
                    <input type="number" name="dosage_amount" id="dosage_amount" class="form-control" 
                           value="{{ old('dosage_amount', $product->dosage_amount) }}" step="0.01" required>
                    <div class="invalid-feedback" id="dosageAmountError">
                        <i class="fas fa-exclamation-circle"></i> Dosage amount is required.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-ruler"></i> Dosage Unit
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $product->dosage_unit ?? 'N/A' }}</span>
                    </label>
                    <select name="dosage_unit" id="dosage_unit" class="form-control" required>
                        <option value="">Select Unit</option>
                        <option value="mg" {{ old('dosage_unit', $product->dosage_unit) == 'mg' ? 'selected' : '' }}>mg</option>
                        <option value="ml" {{ old('dosage_unit', $product->dosage_unit) == 'ml' ? 'selected' : '' }}>ml</option>
                        <option value="g" {{ old('dosage_unit', $product->dosage_unit) == 'g' ? 'selected' : '' }}>g</option>
                        <option value="L" {{ old('dosage_unit', $product->dosage_unit) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="IU" {{ old('dosage_unit', $product->dosage_unit) == 'IU' ? 'selected' : '' }}>IU</option>
                    </select>
                    <div class="invalid-feedback" id="dosageUnitError">
                        <i class="fas fa-exclamation-circle"></i> Dosage unit is required.
                    </div>
                </div>
            </div>

            <!-- ===== FORM (with Auto-Detect) ===== -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-capsules"></i> Form
                    <span class="required">*</span>
                    <span class="badge-auto">Auto Unit</span>
                    <span class="current-value">Current: {{ $product->form ?? 'N/A' }}</span>
                </label>
                <select name="form" id="form" class="form-control" required>
                    <option value="">Select Form</option>
                    @foreach($dosageForms as $dosageForm)
                        <option value="{{ $dosageForm->name }}" data-unit="{{ $dosageForm->abbreviation ?? '' }}"
                            {{ old('form', $product->form) == $dosageForm->name ? 'selected' : '' }}>
                            {{ $dosageForm->name }}
                            @if($dosageForm->abbreviation)
                                ({{ $dosageForm->abbreviation }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="formError">
                    <i class="fas fa-exclamation-circle"></i> Form is required.
                </div>
            </div>

            <!-- ===== UNIT AUTO-DETECT DISPLAY ===== -->
            <div class="form-group" id="unitDisplayGroup" style="display: none;">
                <div class="unit-display">
                    <i class="fas fa-check-circle"></i>
                    <span>Auto-detected:</span>
                    <span class="unit-value" id="displayUnit">—</span>
                    <span class="no-unit" id="noUnitMessage" style="display: none;">No unit</span>
                </div>
            </div>

            <!-- ===== TYPE & CATEGORY ===== -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag"></i> Type
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $product->type ?? 'N/A' }}</span>
                    </label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Generic" {{ old('type', $product->type) == 'Generic' ? 'selected' : '' }}>Generic</option>
                        <option value="Branded" {{ old('type', $product->type) == 'Branded' ? 'selected' : '' }}>Branded</option>
                    </select>
                    <div class="invalid-feedback" id="typeError">
                        <i class="fas fa-exclamation-circle"></i> Type is required.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-folder"></i> Category
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $product->category ?? 'N/A' }}</span>
                    </label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" 
                                {{ old('category', $product->category) == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="categoryError">
                        <i class="fas fa-exclamation-circle"></i> Category is required.
                    </div>
                </div>
            </div>

            <!-- ===== DRUG CLASSIFICATION ===== -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-capsules"></i> Drug Classification
                    <span class="required">*</span>
                    <span class="current-value">Current: {{ $product->drugClassification->name ?? 'None' }}</span>
                </label>
                <select name="drug_classification_id" id="drug_classification_id" class="form-control" required>
                    <option value="">Select Classification</option>
                    @foreach($drugClassifications as $classification)
                        <option value="{{ $classification->id }}" 
                            {{ old('drug_classification_id', $product->drug_classification_id) == $classification->id ? 'selected' : '' }}>
                            {{ $classification->name }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="drugClassificationError">
                    <i class="fas fa-exclamation-circle"></i> Drug classification is required.
                </div>
            </div>

            <!-- ===== PRICE ===== -->
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-money-bill-wave"></i> Price (₱)
                    <span class="required">*</span>
                    <span class="current-value">Current: ₱{{ number_format($product->price, 2) }}</span>
                </label>
                <input type="number" name="price" id="price" class="form-control" 
                       value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                <div class="invalid-feedback" id="priceError">
                    <i class="fas fa-exclamation-circle"></i> Price is required.
                </div>
            </div>

            <!-- ===== QUANTITY & PIECES PER BOX ===== -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-boxes"></i> Quantity (Boxes)
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $batch->quantity ?? 0 }}</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" class="form-control" 
                           value="{{ old('quantity', $batch->quantity ?? 1) }}" min="1" required>
                    <div class="invalid-feedback" id="quantityError">
                        <i class="fas fa-exclamation-circle"></i> Quantity is required.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-vector-square"></i> Pieces per Box
                        <span class="required">*</span>
                        <span class="current-value">Current: {{ $batch->pieces_per_box ?? 0 }}</span>
                    </label>
                    <input type="number" name="pieces_per_box" id="pieces_per_box" class="form-control" 
                           value="{{ old('pieces_per_box', $batch->pieces_per_box ?? 10) }}" min="1" required>
                    <div class="invalid-feedback" id="piecesPerBoxError">
                        <i class="fas fa-exclamation-circle"></i> Pieces per box is required.
                    </div>
                </div>
            </div>

            <!-- ===== PIECES LEFT & TOTAL PIECES ===== -->
            <div class="form-row-3">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-boxes"></i> Pieces Left</label>
                    <input type="text" id="piecesLeft" class="form-control calculated-field" readonly 
                           value="{{ number_format($batch->pieces_left ?? 0) }}">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-calculator"></i> Total Pieces</label>
                    <input type="text" id="totalPieces" class="form-control calculated-field" readonly 
                           value="{{ number_format($batch->total_pieces ?? 0) }}">
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-chart-bar"></i> Stock Status</label>
                    <div class="stock-info-box">
                        <span id="stockInfo">{{ number_format($batch->total_pieces ?? 0) }} pcs</span>
                    </div>
                </div>
            </div>

            <!-- ===== EXPIRY & ARRIVAL ===== -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-times"></i> Expiry Date
                        <span class="current-value">
                            Current: {{ isset($batch->expiry_date) ? \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') : 'N/A' }}
                        </span>
                    </label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" 
                           value="{{ old('expiry_date', isset($batch->expiry_date) ? \Carbon\Carbon::parse($batch->expiry_date)->format('Y-m-d') : '') }}">
                    <span class="form-text">Optional</span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-plus"></i> Arrival Date
                        <span class="current-value">
                            Current: {{ isset($batch->arrival_date) ? \Carbon\Carbon::parse($batch->arrival_date)->format('Y-m-d') : 'N/A' }}
                        </span>
                    </label>
                    <input type="date" name="arrival_date" id="arrival_date" class="form-control" 
                           value="{{ old('arrival_date', isset($batch->arrival_date) ? \Carbon\Carbon::parse($batch->arrival_date)->format('Y-m-d') : '') }}">
                </div>
            </div>

            <!-- ===== BATCH INFO (Readonly) ===== -->
            <div class="batch-info-box">
                <div class="form-row">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="batch-label"><i class="fas fa-hashtag"></i> Batch Number</label>
                        <div class="batch-value">{{ $batch->batch_number ?? 'N/A' }}</div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="batch-label"><i class="fas fa-clock"></i> Status</label>
                        <div class="batch-value">
                            @php
                                $status = $batch->status ?? 'available';
                                $statusClass = match($status) {
                                    'available' => 'status-available',
                                    'lowstock' => 'status-lowstock',
                                    'expired' => 'status-expired',
                                    'nearexpired' => 'status-nearexpired',
                                    default => 'status-available'
                                };
                                $statusText = $batch->status_text ?? 'Available';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== IMAGE ===== -->
            <div class="form-group">
                <label class="form-label"><i class="fas fa-image"></i> Product Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)" style="height: auto; padding: 4px 8px;">
                
                <div class="image-preview-container">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" id="preview" class="image-preview">
                        <button type="button" class="remove-image" onclick="removeImage()" title="Remove image">
                            <i class="fas fa-times"></i>
                        </button>
                    @else
                        <img id="preview" class="image-preview" style="display:none;">
                    @endif
                </div>
                <span class="form-text">Max size: 2MB. JPG, PNG only. Leave empty to keep current image.</span>
            </div>

            <!-- ===== BUTTONS ===== -->
            <div class="btn-group-actions">
                <a href="{{ route('inventory.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-save" id="submitBtn">
                    <i class="fas fa-save"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let isSubmitting = false;

    // ============================================
    // IMAGE PREVIEW
    // ============================================
    window.previewImage = function(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    };

    window.removeImage = function() {
        const preview = document.getElementById('preview');
        const fileInput = document.getElementById('image');
        preview.style.display = 'none';
        preview.src = '';
        fileInput.value = '';
        
        if (!$('#remove_image_flag').length) {
            $('<input>').attr({
                type: 'hidden',
                name: 'remove_image',
                id: 'remove_image_flag',
                value: '1'
            }).appendTo('#editForm');
        }
        
        Swal.fire({
            icon: 'info',
            title: 'Image Removed',
            text: 'The image will be removed when you save.',
            timer: 1500,
            showConfirmButton: false
        });
    };

    // Show barcode preview if exists
    @if($product->barcode)
        $('#previewImage').html(`<img src="/barcodes/image/{{ $product->barcode }}" style="height: 45px; border: 1px solid #ddd; padding: 4px; border-radius: 4px; background: white;">`);
        $('#barcodePreview').show();
    @endif

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
        if (total === 0) { stockInfo.css('color', '#dc3545'); }
        else if (total < 100) { stockInfo.css('color', '#f57c00'); }
        else { stockInfo.css('color', '#0b7a33'); }
    }

    $('#quantity, #pieces_per_box').on('input', calculatePieces);

    // ============================================
    // AUTO-DETECT UNIT FROM FORM
    // ============================================
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

    if (formSelect.value) {
        autoDetectUnit();
    }

    // ============================================
    // VALIDATION
    // ============================================
    function validateField(input) {
        const id = $(input).attr('id');
        const value = $(input).val().trim();
        const required = $(input).prop('required');
        
        if (required && !value) {
            $(input).addClass('is-invalid').removeClass('is-valid');
            $(`#${id}Error`).show();
            return false;
        }
        
        if ($(input).attr('type') === 'number') {
            const num = parseFloat(value);
            if (required && (isNaN(num) || num <= 0)) {
                $(input).addClass('is-invalid').removeClass('is-valid');
                $(`#${id}Error`).show();
                return false;
            }
        }
        
        $(input).removeClass('is-invalid').addClass('is-valid');
        $(`#${id}Error`).hide();
        return true;
    }

    $('.form-control[required]').on('blur', function() {
        validateField(this);
    });

    let validationTimeout;
    $('.form-control[required]').on('input', function() {
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            validateField(this);
        }, 300);
    });

    // ============================================
    // FORM SUBMISSION
    // ============================================
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        if (isSubmitting) {
            return false;
        }

        let isValid = true;
        let firstInvalid = null;
        let errorList = '';
        
        $('.form-control[required]').each(function() {
            if (!validateField(this)) {
                isValid = false;
                if (!firstInvalid) {
                    firstInvalid = this;
                }
                const label = $(this).closest('.form-group').find('.form-label').text().trim();
                errorList += `<li><i class="fas fa-exclamation-circle text-danger me-2"></i>${label} is required</li>`;
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Please Complete All Required Fields',
                html: `
                    <div style="text-align: left;">
                        <p class="text-muted">Please fill out all required fields before updating.</p>
                        <ul style="list-style: none; padding: 0; margin-top: 10px;">
                            ${errorList}
                        </ul>
                    </div>
                `,
                confirmButtonColor: '#0b7a33',
                confirmButtonText: 'OK, I\'ll fill it out'
            });
            
            if (firstInvalid) {
                $('html, body').animate({
                    scrollTop: $(firstInvalid).offset().top - 150
                }, 300);
                $(firstInvalid).focus();
            }
            return false;
        }

        isSubmitting = true;
        const submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Updating...');

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Updated!',
                        text: response.message || 'Product updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("inventory.index") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Update failed.',
                        confirmButtonColor: '#dc3545'
                    });
                    isSubmitting = false;
                    submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Update Product');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong. Please try again.';
                
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    let errorList = '';
                    Object.keys(errors).forEach(function(key) {
                        errorList += `<li><strong>${key}:</strong> ${errors[key].join(', ')}</li>`;
                        const field = $(`[name="${key}"]`);
                        if (field.length) {
                            field.addClass('is-invalid').removeClass('is-valid');
                        }
                    });
                    errorMsg = `<ul style="text-align:left; list-style: none; padding: 0;">${errorList}</ul>`;
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Errors',
                        html: errorMsg,
                        confirmButtonColor: '#dc3545'
                    });
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg,
                        confirmButtonColor: '#dc3545'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg,
                        confirmButtonColor: '#dc3545'
                    });
                }
                
                isSubmitting = false;
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Update Product');
            }
        });
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
                    $('#previewImage').html(`<img src="/barcodes/image/${data.barcode}" style="height: 45px; border: 1px solid #ddd; padding: 4px; border-radius: 4px; background: white;">`);
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

    console.log('✅ Edit page loaded successfully!');
});
</script>

{{-- SESSION MESSAGES --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 750px; margin: 20px auto; font-size: 13px;">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle me-2 mt-1"></i>
            <div>
                <strong>{{ session('error') }}</strong>
                @if (session('error_details'))
                    <div class="mt-2" style="font-size: 12px;">
                        {!! session('error_details') !!}
                    </div>
                @endif
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 750px; margin: 20px auto; font-size: 13px;">
        <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle me-2 mt-1"></i>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1" style="padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 750px; margin: 20px auto; font-size: 13px;">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@endsection