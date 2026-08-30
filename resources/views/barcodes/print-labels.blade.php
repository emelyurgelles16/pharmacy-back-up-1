@extends('layouts.app')

@section('title', 'Print Barcode Labels')

@section('content')
<style>
    .product-selector {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
    }
    .product-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-item:hover {
        background: #f8f9fa;
    }
    .qty-input {
        width: 80px;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
        text-align: center;
    }
    .print-btn {
        background: #1b5e20;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }
</style>

<div class="container">
    <div class="header-box">
        <h2><i class="fas fa-print"></i> Print Barcode Labels</h2>
        <p>Select products and quantity for each label</p>
    </div>
    
    <div class="form-card">
        <form id="printForm">
            @csrf
            <div class="product-selector">
                @foreach($products as $product)
                <div class="product-item">
                    <div>
                        <strong>{{ $product->name }}</strong><br>
                        <small>Barcode: {{ $product->formatted_barcode }}</small><br>
                        <small>Price: ₱{{ number_format($product->price, 2) }}</small>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span>Quantity:</span>
                        <input type="number" name="quantities[{{ $product->id }}]" 
                               class="qty-input" value="1" min="0" max="100">
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="margin-top: 20px; text-align: center;">
                <button type="button" id="selectAllBtn" class="btn-save" style="background: #6c757d;">
                    Select All
                </button>
                <button type="submit" class="print-btn">
                    <i class="fas fa-print"></i> Print Labels
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('selectAllBtn').addEventListener('click', function() {
    document.querySelectorAll('.qty-input').forEach(input => {
        if (input.value == '0') input.value = '1';
    });
});

document.getElementById('printForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('{{ route("barcodes.print-labels.post") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'barcode-labels.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);
    });
});
</script>
@endsection