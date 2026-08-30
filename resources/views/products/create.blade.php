@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<style>
    .form-card {
        background: #ffffff;
        padding: 15px 18px;
        border-radius: 10px;
        max-width: 580px;
        max-height: 88vh; /* ✅ Fit sa screen, may scroll */
        overflow-y: auto;
        margin: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #eef2f6;
    }
    /* ✅ Scroll bar styling */
    .form-card::-webkit-scrollbar {
        width: 5px;
    }
    .form-card::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .form-card::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 10px;
    }
    .form-card::-webkit-scrollbar-thumb:hover {
        background: #2e7d32;
    }
    .form-card {
        scrollbar-width: thin;
        scrollbar-color: #1b5e20 #f1f1f1;
    }

    .form-card h2 {
        color: #1b5e20;
        margin-bottom: 12px;
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        position: sticky;
        top: 0;
        background: white;
        z-index: 5;
        padding-bottom: 8px;
        border-bottom: 2px solid #e9ecef;
    }
    .form-card h2 i {
        color: #0a8737;
        font-size: 16px;
    }
    .form-group {
        margin-bottom: 8px;
    }
    label {
        font-weight: 600;
        margin-bottom: 2px;
        display: block;
        font-size: 12px;
        color: #333;
    }
    label .required {
        color: #dc3545;
    }
    label .badge-auto {
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 8px;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 8px;
        margin-left: 4px;
        text-transform: uppercase;
    }
    input, select {
        width: 100%;
        padding: 5px 10px;
        border-radius: 5px;
        border: 2px solid #e9ecef;
        font-size: 12px;
        transition: all 0.3s ease;
        background: white;
        height: 32px;
    }
    input:focus, select:focus {
        border-color: #1b5e20;
        outline: none;
        box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.08);
    }
    input[readonly] {
        background: #f8f9fa;
        cursor: not-allowed;
        border-color: #dee2e6;
        font-weight: 600;
        color: #1b5e20;
        font-size: 12px;
    }
    .image-preview {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        margin-top: 4px;
        border: 2px dashed #ccc;
        padding: 2px;
        background: white;
    }
    .btn-save {
        background: linear-gradient(135deg, #1b5e20, #0a8737);
        color: white;
        padding: 8px;
        border: none;
        width: 100%;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 2px 6px rgba(11, 122, 51, 0.15);
        height: 36px;
        position: sticky;
        bottom: 0;
        z-index: 5;
        margin-top: 4px;
    }
    .btn-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.25);
    }
    .btn-save:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 8px;
    }
    .unit-display {
        background: #f8f9fa;
        padding: 4px 10px;
        border-radius: 5px;
        border: 2px solid #e9ecef;
        min-height: 28px;
        display: flex;
        align-items: center;
        font-size: 12px;
    }
    .unit-display .unit-value {
        font-weight: 700;
        color: #1b5e20;
        margin-left: 3px;
    }
    .unit-display .no-unit {
        color: #999;
        font-style: italic;
    }
    .calculated-field {
        background: #e8f5e9 !important;
        border: 2px solid #1b5e20 !important;
        font-weight: 700;
        color: #1b5e20 !important;
        font-size: 12px !important;
        height: 28px !important;
        padding: 3px 8px !important;
    }
    .stock-info-box {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        padding: 4px 10px;
        border-radius: 5px;
        text-align: center;
        border: 2px solid #1b5e20;
        min-height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #1b5e20;
        font-size: 12px;
    }
    .barcode-wrapper {
        display: flex;
        gap: 6px;
    }
    .barcode-wrapper input {
        flex: 1;
        height: 30px;
        padding: 4px 8px;
        font-size: 11px;
    }
    .barcode-wrapper .btn-generate {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0 12px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
        font-size: 11px;
        height: 30px;
    }
    .barcode-wrapper .btn-generate:hover {
        background: #5a6268;
    }
    .text-muted-small {
        color: #6c757d;
        font-size: 10px;
        margin-top: 1px;
        display: block;
    }
    .form-divider {
        border: none;
        border-top: 1px dashed #e9ecef;
        margin: 10px 0;
    }
    .barcode-box {
        background: #f8f9fa;
        padding: 8px 10px;
        border-radius: 6px;
        margin-bottom: 8px;
        border: 1px solid #e9ecef;
    }
    .barcode-box .form-group {
        margin-bottom: 0;
    }
    @media (max-width: 768px) {
        .form-row, .form-row-3 {
            grid-template-columns: 1fr;
        }
        .form-card {
            padding: 12px;
            margin: 5px;
            max-height: 85vh;
        }
        .barcode-wrapper {
            flex-direction: column;
        }
        .barcode-wrapper .btn-generate {
            width: 100%;
            height: 30px;
        }
    }
</style>

<div class="container-fluid py-1">
    <div class="form-card">

        <h2>
            <i class="fas fa-plus-circle"></i> Add Product
        </h2>

        <form id="productForm" action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- PRODUCT NAME -->
            <div class="form-group">
                <label>Product Name <span class="required">*</span></label>
                <input type="text" name="name" id="productName" required placeholder="Enter product name...">
            </div>

            <!-- BARCODE -->
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
                <div id="barcodePreview" style="display: none; text-align: center; margin-top: 4px; padding: 4px; background: white; border-radius: 4px; border: 1px solid #e9ecef;">
                    <div id="previewImage"></div>
                </div>
            </div>

            <!-- BRAND -->
            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" placeholder="e.g., Unilab">
            </div>

            <!-- DOSAGE -->
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

            <!-- FORM -->
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

            <!-- UNIT AUTO-DETECT -->
            <div class="form-group" id="unitDisplayGroup" style="display: none;">
                <div class="unit-display">
                    <i class="fas fa-check-circle" style="color: #1b5e20; font-size: 12px;"></i>
                    <span style="margin-left: 4px;">Auto-detected:</span>
                    <span class="unit-value" id="displayUnit">—</span>
                    <span class="no-unit" id="noUnitMessage" style="display: none;">No unit</span>
                </div>
            </div>

            <!-- TYPE & CATEGORY -->
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

            <!-- PRICE -->
            <div class="form-group">
                <label>Price (₱) <span class="required">*</span></label>
                <input type="number" name="price" step="0.01" required placeholder="0.00" min="0">
            </div>

            <!-- QUANTITY & PIECES PER BOX -->
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

            <!-- PIECES LEFT & TOTAL PIECES -->
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

            <!-- EXPIRY & ARRIVAL -->
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

            <!-- IMAGE -->
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" id="imageInput" onchange="previewImage(event)" accept="image/*" style="height: 30px; padding: 2px 8px;">
                <img id="preview" class="image-preview" style="display:none;">
                <small class="text-muted-small">Max 2MB. JPG, PNG.</small>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn-save" id="submitBtn">
                <i class="fas fa-save"></i> Save Product
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// IMAGE PREVIEW
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

// CALCULATE PIECES
function calculatePieces() {
    const qty = parseInt(document.getElementById('quantity').value) || 0;
    const pcs = parseInt(document.getElementById('pieces_per_box').value) || 0;
    const total = qty * pcs;

    document.getElementById('totalPieces').value = total.toLocaleString();
    document.getElementById('piecesLeft').value = total.toLocaleString();
    document.getElementById('stockInfo').textContent = total.toLocaleString() + ' pcs';

    const stockInfo = document.getElementById('stockInfo');
    if (total === 0) { stockInfo.style.color = '#dc3545'; }
    else if (total < 100) { stockInfo.style.color = '#f57c00'; }
    else { stockInfo.style.color = '#1b5e20'; }
}

// AUTO-FILL UNIT
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

// GENERATE BARCODE
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
                `<img src="/barcodes/image/${data.barcode}" style="height: 40px; border: 1px solid #ddd; padding: 3px; border-radius: 4px;">`;
            document.getElementById('barcodePreview').style.display = 'block';
            Swal.fire({ icon: 'success', title: 'Generated!', text: data.barcode, timer: 1200, showConfirmButton: false });
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

// PREVENT DOUBLE SUBMIT
document.getElementById('productForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
});
</script>
@endsection