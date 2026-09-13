@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - ADD PRODUCT
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
        padding: 20px 25px;
        border-radius: 12px;
        max-width: 650px;
        margin: 0 auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #eef2f6;
        max-height: 85vh;
        overflow-y: auto;
    }

    .form-card::-webkit-scrollbar {
        width: 5px;
    }
    .form-card::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .form-card::-webkit-scrollbar-thumb {
        background: #0b7a33;
        border-radius: 10px;
    }
    .form-card::-webkit-scrollbar-thumb:hover {
        background: #056b28;
    }
    .form-card {
        scrollbar-width: thin;
        scrollbar-color: #0b7a33 #f1f1f1;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-group {
        margin-bottom: 12px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
        font-size: 13px;
        color: #333;
    }

    .form-label .required {
        color: #dc3545;
    }

    .form-label .badge-auto {
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 9px;
        font-weight: 600;
        padding: 2px 10px;
        border-radius: 10px;
        margin-left: 6px;
        text-transform: uppercase;
    }

    .form-control {
        width: 100%;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        font-size: 13px;
        transition: all 0.3s ease;
        background: white;
        height: 38px;
    }

    .form-control:focus {
        border-color: #0b7a33;
        outline: none;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
    }

    .form-control[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
        border-color: #dee2e6;
        font-weight: 600;
        color: #0b7a33;
    }

    .form-control.calculated-field {
        background: #e8f5e9 !important;
        border: 1.5px solid #0b7a33 !important;
        font-weight: 700;
        color: #0b7a33 !important;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    textarea.form-control {
        height: auto;
        min-height: 60px;
        resize: vertical;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
        display: block;
    }

    /* ===== FORM ROW ===== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }

    /* ===== UNIT DISPLAY ===== */
    .unit-display {
        background: #f8f9fa;
        padding: 6px 14px;
        border-radius: 6px;
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

    /* ===== STOCK INFO BOX ===== */
    .stock-info-box {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        padding: 6px 14px;
        border-radius: 6px;
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

    /* ===== BARCODE ===== */
    .barcode-wrapper {
        display: flex;
        gap: 8px;
    }

    .barcode-wrapper .form-control {
        flex: 1;
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

    .barcode-box {
        background: #f8f9fa;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        border: 1px solid #e9ecef;
    }

    .barcode-box .form-group {
        margin-bottom: 0;
    }

    #barcodePreview {
        display: none;
        text-align: center;
        margin-top: 8px;
        padding: 8px;
        background: white;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    #barcodePreview img {
        height: 45px;
        border: 1px solid #ddd;
        padding: 4px;
        border-radius: 4px;
    }

    /* ===== IMAGE PREVIEW ===== */
    .image-preview {
        width: 80px;
        height: 80px;
        border-radius: 6px;
        object-fit: cover;
        margin-top: 8px;
        border: 2px dashed #ccc;
        padding: 4px;
        background: white;
    }

    /* ===== BUTTONS ===== */
    .btn-save {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 10px;
        border: none;
        width: 100%;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(11, 122, 51, 0.15);
        height: 42px;
        margin-top: 8px;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(11, 122, 51, 0.3);
    }

    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    /* ===== DIVIDER ===== */
    .form-divider {
        border: none;
        border-top: 1px dashed #e9ecef;
        margin: 14px 0;
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
            max-height: 85vh;
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
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .form-label {
            font-size: 12px;
        }
        .form-control {
            font-size: 12px;
            padding: 5px 10px;
            height: 34px;
        }
        .btn-save {
            font-size: 13px;
            height: 38px;
        }
        .stock-info-box {
            font-size: 12px;
            min-height: 34px;
        }
        .unit-display {
            font-size: 12px;
            min-height: 34px;
        }
        .image-preview {
            width: 60px;
            height: 60px;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-plus-circle"></i>
            Add Product
        </h2>
        <a href="{{ route('inventory.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Inventory
        </a>
    </div>

    <!-- ===== FORM CARD ===== -->
    <div class="form-card">
        <form id="productForm" action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- PRODUCT NAME -->
            <div class="form-group">
                <label class="form-label">Product Name <span class="required">*</span></label>
                <input type="text" name="name" id="productName" class="form-control" placeholder="Enter product name..." required>
            </div>

            <!-- BARCODE -->
            <div class="barcode-box">
                <div class="form-group">
                    <label class="form-label">Barcode</label>
                    <div class="barcode-wrapper">
                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Scan barcode..." style="font-family: monospace; letter-spacing: 1px;">
                        <button type="button" id="generateBarcodeBtn" class="btn-generate">
                            <i class="fas fa-sync-alt"></i> Generate
                        </button>
                    </div>
                    <span class="form-text">Leave blank to auto-generate</span>
                </div>
                <div id="barcodePreview">
                    <div id="previewImage"></div>
                </div>
            </div>

            <!-- BRAND -->
            <div class="form-group">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" placeholder="e.g., Unilab">
            </div>

            <!-- DOSAGE -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Dosage Amount <span class="required">*</span></label>
                    <input type="number" step="0.01" name="dosage_amount" id="dosage_amount" class="form-control" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Unit <span class="required">*</span></label>
                    <select name="dosage_unit" id="dosage_unit" class="form-control" required>
                        <option value="">Select Unit</option>
                        <option value="mg">mg</option>
                        <option value="ml">ml</option>
                        <option value="g">g</option>
                        <option value="L">L</option>
                        <option value="IU">IU</option>
                    </select>
                </div>
            </div>

            <!-- FORM -->
            <div class="form-group">
                <label class="form-label">Form <span class="required">*</span> <span class="badge-auto">Auto Unit</span></label>
                <select name="form" id="form" class="form-control" required>
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

            <!-- UNIT AUTO-DETECT -->
            <div class="form-group" id="unitDisplayGroup" style="display: none;">
                <div class="unit-display">
                    <i class="fas fa-check-circle" style="color: #0b7a33; font-size: 13px;"></i>
                    <span style="margin-left: 6px;">Auto-detected:</span>
                    <span class="unit-value" id="displayUnit">—</span>
                    <span class="no-unit" id="noUnitMessage" style="display: none;">No unit</span>
                </div>
            </div>

            <!-- TYPE & CATEGORY -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Type <span class="required">*</span></label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Generic">Generic</option>
                        <option value="Branded">Branded</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Category <span class="required">*</span></label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- DRUG CLASSIFICATION -->
            <div class="form-group">
                <label class="form-label">Drug Classification <span class="required">*</span></label>
                <select name="drug_classification_id" id="drug_classification_id" class="form-control" required>
                    <option value="">Select Classification</option>
                    @foreach($drugClassifications as $classification)
                        <option value="{{ $classification->id }}">{{ $classification->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- PRICE -->
            <div class="form-group">
                <label class="form-label">Price (₱) <span class="required">*</span></label>
                <input type="number" name="price" step="0.01" class="form-control" placeholder="0.00" min="0" required>
            </div>

            <!-- QUANTITY & PIECES PER BOX -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Qty (Boxes) <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required min="1" value="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Pcs/Box <span class="required">*</span></label>
                    <input type="number" name="pieces_per_box" id="pieces_per_box" class="form-control" required min="1" value="10">
                </div>
            </div>

            <!-- PIECES LEFT & TOTAL PIECES -->
            <div class="form-row-3">
                <div class="form-group">
                    <label class="form-label">Pieces Left</label>
                    <input type="text" id="piecesLeft" class="form-control calculated-field" readonly value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Pieces</label>
                    <input type="text" id="totalPieces" class="form-control calculated-field" readonly value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Stock Status</label>
                    <div class="stock-info-box">
                        <span id="stockInfo">0 pcs</span>
                    </div>
                </div>
            </div>

            <!-- EXPIRY & ARRIVAL -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                    <span class="form-text">Optional</span>
                </div>
                <div class="form-group">
                    <label class="form-label">Arrival Date <span class="required">*</span></label>
                    <input type="date" name="arrival_date" id="arrival_date" class="form-control" required>
                </div>
            </div>

            <!-- IMAGE -->
            <div class="form-group">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" id="imageInput" class="form-control" onchange="previewImage(event)" accept="image/*" style="height: auto; padding: 4px 8px;">
                <img id="preview" class="image-preview" style="display:none;">
                <span class="form-text">Max 2MB. JPG, PNG.</span>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn-save" id="submitBtn">
                <i class="fas fa-save"></i> Save Product
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// IMAGE PREVIEW
// ============================================
function previewImage(event) {
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
}

// ============================================
// CALCULATE PIECES
// ============================================
function calculatePieces() {
    const qty = parseInt(document.getElementById('quantity').value) || 0;
    const pcs = parseInt(document.getElementById('pieces_per_box').value) || 0;
    const total = qty * pcs;

    document.getElementById('totalPieces').value = total.toLocaleString();
    document.getElementById('piecesLeft').value = total.toLocaleString();
    
    const stockInfo = document.getElementById('stockInfo');
    stockInfo.textContent = total.toLocaleString() + ' pcs';
    
    if (total === 0) { stockInfo.style.color = '#dc3545'; }
    else if (total < 100) { stockInfo.style.color = '#f57c00'; }
    else { stockInfo.style.color = '#0b7a33'; }
}

// ============================================
// AUTO-FILL UNIT
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const formSelect = document.getElementById('form');
    const unitSelect = document.getElementById('dosage_unit');
    const displayGroup = document.getElementById('unitDisplayGroup');
    const displayUnit = document.getElementById('displayUnit');
    const noUnitMsg = document.getElementById('noUnitMessage');

    // Default arrival date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('arrival_date').value = today;

    calculatePieces();

    document.getElementById('quantity').addEventListener('input', calculatePieces);
    document.getElementById('pieces_per_box').addEventListener('input', calculatePieces);

    formSelect.addEventListener('change', function() {
        const unit = this.options[this.selectedIndex].getAttribute('data-unit');

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
    });

    if (formSelect.value) {
        formSelect.dispatchEvent(new Event('change'));
    }
});

// ============================================
// GENERATE BARCODE
// ============================================
document.getElementById('generateBarcodeBtn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('/barcodes/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.barcode) {
            document.getElementById('barcode').value = data.barcode;
            document.getElementById('previewImage').innerHTML = 
                `<img src="/barcodes/image/${data.barcode}" style="height: 45px; border: 1px solid #ddd; padding: 4px; border-radius: 4px;">`;
            document.getElementById('barcodePreview').style.display = 'block';
            Swal.fire({ 
                icon: 'success', 
                title: 'Generated!', 
                text: data.barcode, 
                timer: 1200, 
                showConfirmButton: false 
            });
        }
    })
    .catch(() => {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to generate barcode.' });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-sync-alt"></i> Generate';
    });
});

// ============================================
// PREVENT DOUBLE SUBMIT
// ============================================
document.getElementById('productForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
});
</script>
@endsection