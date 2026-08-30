@extends('layouts.app')

@section('title', 'Create Prescription')

@section('content')
<style>
    .header-box {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .header-box h2 {
        margin-bottom: 8px;
        font-weight: 700;
    }
    
    .header-box p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .prescription-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 25px;
    }
    
    .prescription-card:hover {
        box-shadow: 0 5px 25px rgba(0,0,0,0.12);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 16px;
        border: none;
    }
    
    .card-header-custom i {
        margin-right: 10px;
    }
    
    .card-body-custom {
        padding: 25px;
    }
    
    .prescription-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        position: relative;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .prescription-item:hover {
        border-color: #1b5e20;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .remove-item {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .remove-item:hover {
        background: #c82333;
        transform: scale(1.05);
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1b5e20;
        box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
    }
    
    label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .required:after {
        content: " *";
        color: #dc3545;
    }
    
    .btn-add-item {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 8px 20px;
        transition: all 0.3s;
    }
    
    .btn-add-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(27, 94, 32, 0.3);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 100%);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(27, 94, 32, 0.4);
    }
    
    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 35px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        margin-bottom: 20px;
    }
    
    .item-number {
        display: inline-block;
        background: #1b5e20;
        color: white;
        border-radius: 20px;
        padding: 2px 12px;
        font-size: 12px;
        margin-bottom: 15px;
    }
    
    /* Animation for new items */
    .prescription-item-new {
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .form-buttons {
            flex-direction: column;
        }
        .btn-save, .btn-cancel {
            width: 100%;
        }
    }
</style>

<div class="container-fluid">
    <div class="header-box">
        <h2><i class="fas fa-prescription-bottle"></i> Create Prescription</h2>
        <p><i class="fas fa-clinic-medical"></i> Fill out the prescription details below</p>
    </div>

    <form id="prescriptionForm" action="{{ route('prescriptions.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <!-- Patient Information -->
            <div class="col-md-6">
                <div class="prescription-card card">
                    <div class="card-header-custom">
                        <i class="fas fa-user-circle"></i> Patient Information
                    </div>
                    <div class="card-body-custom">
                        <div class="mb-3">
                            <label class="required">Full Name</label>
                            <input type="text" name="patient_name" class="form-control" placeholder="Enter patient's full name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Age (years)</label>
                                <input type="number" name="patient_age" class="form-control" placeholder="e.g., 25" min="0">
                            </div>
                            <div class="col-md-6">
                                <label>Contact Number</label>
                                <input type="text" name="patient_contact" class="form-control" placeholder="e.g., 09123456789">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label>Complete Address</label>
                            <textarea name="patient_address" class="form-control" rows="2" placeholder="House number, Street, Barangay, City"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor Information -->
            <div class="col-md-6">
                <div class="prescription-card card">
                    <div class="card-header-custom">
                        <i class="fas fa-stethoscope"></i> Doctor Information
                    </div>
                    <div class="card-body-custom">
                        <div class="mb-3">
                            <label class="required">Doctor's Full Name</label>
                            <input type="text" name="doctor_name" class="form-control" placeholder="Enter doctor's full name" required>
                        </div>
                        <div class="mb-3">
                            <label>PRC License Number</label>
                            <input type="text" name="doctor_license" class="form-control" placeholder="e.g., 123456">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription Details -->
        <div class="prescription-card card">
            <div class="card-header-custom">
                <i class="fas fa-calendar-alt"></i> Prescription Details
            </div>
            <div class="card-body-custom">
                <div class="row">
                    <div class="col-md-6">
                        <label class="required">Date Issued</label>
                        <input type="date" name="date_issued" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label>Valid Until</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Leave empty if no expiration</small>
                    </div>
                </div>
                <div class="mt-3">
                    <label>Special Instructions</label>
                    <textarea name="special_instructions" class="form-control" rows="3" placeholder="e.g., Take with food, Avoid alcohol, Refrain from driving, etc."></textarea>
                </div>
            </div>
        </div>

        <!-- Medication Items -->
        <div class="prescription-card card">
            <div class="card-header-custom" style="display: flex; justify-content: space-between; align-items: center;">
                <span><i class="fas fa-tablets"></i> Medication List</span>
                <button type="button" id="addItemBtn" class="btn-add-item">
                    <i class="fas fa-plus-circle"></i> Add Medication
                </button>
            </div>
            <div class="card-body-custom">
                <div id="itemsContainer">
                    <div class="prescription-item" data-item-index="0">
                        <span class="item-number">Item #1</span>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="required">Medicine Name</label>
                                <input type="text" name="items[0][product_name]" class="form-control" list="productsList" placeholder="Search medicine..." required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Dosage Strength</label>
                                <input type="text" name="items[0][dosage]" class="form-control" placeholder="e.g., 500mg">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="required">Quantity</label>
                                <input type="number" name="items[0][quantity]" class="form-control" placeholder="No. of pieces" required min="1">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Frequency</label>
                                <input type="text" name="items[0][frequency]" class="form-control" placeholder="e.g., 3x/day">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Duration</label>
                                <input type="text" name="items[0][duration]" class="form-control" placeholder="e.g., 7 days">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>Special Note (Optional)</label>
                                <input type="text" name="items[0][special_note]" class="form-control" placeholder="e.g., Take before bedtime, With meals, etc.">
                            </div>
                        </div>
                        <button type="button" class="btn remove-item"><i class="fas fa-trash-alt"></i> Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Save Prescription
            </button>
            <a href="{{ route('prescriptions.index') }}" class="btn-cancel">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
        </div>
    </form>
</div>

<datalist id="productsList">
    @foreach($products as $product)
    <option value="{{ $product->name }}" data-id="{{ $product->id }}">
    @endforeach
</datalist>

<script>
let itemCount = 1;

// Add new medication item
$('#addItemBtn').click(function() {
    const newIndex = itemCount;
    const newItem = `
        <div class="prescription-item prescription-item-new" data-item-index="${newIndex}">
            <span class="item-number">Item #${newIndex + 1}</span>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="required">Medicine Name</label>
                    <input type="text" name="items[${newIndex}][product_name]" class="form-control" list="productsList" placeholder="Search medicine..." required>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Dosage Strength</label>
                    <input type="text" name="items[${newIndex}][dosage]" class="form-control" placeholder="e.g., 500mg">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="required">Quantity</label>
                    <input type="number" name="items[${newIndex}][quantity]" class="form-control" placeholder="No. of pieces" required min="1">
                </div>
                <div class="col-md-2 mb-3">
                    <label>Frequency</label>
                    <input type="text" name="items[${newIndex}][frequency]" class="form-control" placeholder="e.g., 3x/day">
                </div>
                <div class="col-md-2 mb-3">
                    <label>Duration</label>
                    <input type="text" name="items[${newIndex}][duration]" class="form-control" placeholder="e.g., 7 days">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Special Note (Optional)</label>
                    <input type="text" name="items[${newIndex}][special_note]" class="form-control" placeholder="e.g., Take before bedtime, With meals, etc.">
                </div>
            </div>
            <button type="button" class="btn remove-item"><i class="fas fa-trash-alt"></i> Remove</button>
        </div>
    `;
    $('#itemsContainer').append(newItem);
    itemCount++;
    
    // Scroll to new item
    $('html, body').animate({
        scrollTop: $(document).height()
    }, 500);
});

// Remove medication item
$(document).on('click', '.remove-item', function() {
    if ($('.prescription-item').length > 1) {
        $(this).closest('.prescription-item').remove();
        
        // Renumber remaining items
        $('.prescription-item').each(function(index) {
            $(this).find('.item-number').text('Item #' + (index + 1));
            $(this).attr('data-item-index', index);
            
            // Update input names
            $(this).find('input').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    name = name.replace(/items\[\d+\]/, `items[${index}]`);
                    $(this).attr('name', name);
                }
            });
        });
        
        itemCount = $('.prescription-item').length;
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Cannot Remove',
            text: 'At least one medication is required.',
            confirmButtonColor: '#1b5e20'
        });
    }
});

// Stock validation when quantity changes
$(document).on('change', 'input[name$="[quantity]"]', function() {
    let $row = $(this).closest('.prescription-item');
    let productName = $row.find('input[name$="[product_name]"]').val();
    let quantity = $(this).val();
    
    if (productName && quantity && parseInt(quantity) > 0) {
        $.ajax({
            url: '/products/stock/' + encodeURIComponent(productName),
            method: 'GET',
            success: function(data) {
                if (parseInt(quantity) > data.available) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Low Stock Warning',
                        html: `Only <strong>${data.available}</strong> pcs available in stock!<br>You prescribed <strong>${quantity}</strong> pcs.`,
                        confirmButtonColor: '#ff9800'
                    });
                }
            },
            error: function() {
                // Product not found or error, ignore
            }
        });
    }
});

// Form submission with SweetAlert
$('#prescriptionForm').on('submit', function(e) {
    e.preventDefault();
    
    let form = $(this);
    let formData = new FormData(this);
    
    Swal.fire({
        title: 'Saving Prescription...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Prescription saved successfully!',
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#f8f9fa',
                    backdrop: true
                }).then(() => {
                    window.location.href = response.redirect;
                });
            }
        },
        error: function(xhr) {
            let errorMsg = '';
            
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                errorMsg = '<ul style="text-align: left; margin: 0;">';
                for (let key in errors) {
                    errorMsg += '<li><i class="fas fa-exclamation-circle" style="color: #dc3545;"></i> ' + errors[key][0] + '</li>';
                }
                errorMsg += '</ul>';
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMsg,
                    confirmButtonText: 'Got it!',
                    confirmButtonColor: '#dc3545'
                });
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON.message,
                    confirmButtonColor: '#dc3545'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#dc3545'
                });
            }
            
            console.log('Error:', xhr.responseText);
        }
    });
});

// Auto-set valid_until to +30 days when date_issued changes
$('input[name="date_issued"]').on('change', function() {
    let dateIssued = $(this).val();
    if (dateIssued && !$('input[name="valid_until"]').val()) {
        let newDate = new Date(dateIssued);
        newDate.setDate(newDate.getDate() + 30);
        let year = newDate.getFullYear();
        let month = String(newDate.getMonth() + 1).padStart(2, '0');
        let day = String(newDate.getDate()).padStart(2, '0');
        $('input[name="valid_until"]').val(`${year}-${month}-${day}`);
    }
});
</script>
@endsection