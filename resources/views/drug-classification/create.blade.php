@extends('layouts.app')

@section('title', 'Add Drug Classification')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - ADD DRUG CLASSIFICATION
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
        max-width: 650px;
        margin: 0 auto;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #eef2f6;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }

    .form-label .required {
        color: #dc3545;
        margin-left: 2px;
    }

    .form-control, .form-select {
        width: 100%;
        border-radius: 8px;
        padding: 8px 14px;
        border: 1.5px solid #e0e0e0;
        font-size: 13px;
        transition: all 0.3s;
        background: white;
        height: 38px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        display: none;
    }

    .invalid-feedback.show {
        display: block;
    }

    textarea.form-control {
        height: auto;
        resize: vertical;
        min-height: 80px;
    }

    .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 3px;
        display: block;
    }

    /* ===== CHECKBOX GROUP ===== */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 0;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #0b7a33;
        cursor: pointer;
        flex-shrink: 0;
    }

    .checkbox-group label {
        font-size: 13px;
        cursor: pointer;
        margin: 0;
        font-weight: 500;
    }

    /* ===== BUTTONS ===== */
    .btn-submit {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 10px 32px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(11, 122, 51, 0.3);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        padding: 10px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
        color: #333;
        text-decoration: none;
    }

    /* ===== DIVIDER ===== */
    .form-divider {
        border: none;
        border-top: 1px solid #e9ecef;
        margin: 20px 0 16px 0;
    }

    .btn-group-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 18px;
        border-top: 1px solid #e9ecef;
        margin-top: 4px;
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
            padding: 16px 18px;
            margin: 0 5px;
        }
        .btn-group-actions {
            flex-direction: column;
        }
        .btn-submit, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
        .form-label {
            font-size: 12px;
        }
        .form-control, .form-select {
            font-size: 12px;
            padding: 6px 10px;
            height: 34px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .form-card {
            padding: 12px 14px;
        }
        .checkbox-group label {
            font-size: 12px;
        }
        .btn-submit, .btn-cancel {
            font-size: 13px;
            padding: 8px 16px;
        }
        .form-group {
            margin-bottom: 14px;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-plus-circle"></i>
            Add Drug Classification
        </h2>
        <a href="{{ route('drug-classification.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- ===== FORM CARD ===== -->
    <div class="form-card">
        <form action="{{ route('drug-classification.store') }}" method="POST" id="classificationForm">
            @csrf

            <!-- ===== NAME ===== -->
            <div class="form-group">
                <label class="form-label">
                    Classification Name <span class="required">*</span>
                </label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       placeholder="e.g., Over-the-Counter (OTC)" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback show">{{ $message }}</div>
                @enderror
            </div>

            <!-- ===== DESCRIPTION ===== -->
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="3" placeholder="Describe this classification...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback show">{{ $message }}</div>
                @enderror
            </div>

            <!-- ===== REQUIREMENTS ===== -->
            <div class="form-group">
                <label class="form-label">Requirements</label>
                <div class="checkbox-group">
                    <input type="checkbox" name="requires_prescription" id="requires_prescription" value="1" {{ old('requires_prescription') ? 'checked' : '' }}>
                    <label for="requires_prescription">📋 Requires Prescription</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="requires_special_handling" id="requires_special_handling" value="1" {{ old('requires_special_handling') ? 'checked' : '' }}>
                    <label for="requires_special_handling">⚠️ Requires Special Handling</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="requires_logging" id="requires_logging" value="1" {{ old('requires_logging') ? 'checked' : '' }}>
                    <label for="requires_logging">📝 Requires Logging</label>
                </div>
            </div>

            <!-- ===== STATUS ===== -->
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active">✅ Active</label>
                </div>
                <span class="form-text">Uncheck to deactivate this classification</span>
            </div>

            <!-- ===== BUTTONS ===== -->
            <div class="btn-group-actions">
                <a href="{{ route('drug-classification.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save"></i> Save Classification
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
    // REAL-TIME VALIDATION
    // ============================================
    function validateField(input) {
        const id = $(input).attr('id');
        const value = $(input).val().trim();
        const required = $(input).prop('required');
        
        if (required && !value) {
            $(input).addClass('is-invalid').removeClass('is-valid');
            return false;
        }
        
        $(input).removeClass('is-invalid').addClass('is-valid');
        return true;
    }

    $('#name').on('blur', function() {
        validateField(this);
    });

    $('#name').on('input', function() {
        if ($(this).hasClass('is-invalid')) {
            validateField(this);
        }
    });

    // ============================================
    // FORM SUBMISSION
    // ============================================
    $('#classificationForm').on('submit', function(e) {
        e.preventDefault();
        
        if (isSubmitting) {
            return false;
        }

        // Validate name
        if (!validateField($('#name')[0])) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Classification Name is required.',
                confirmButtonColor: '#dc3545'
            });
            $('#name').focus();
            return false;
        }

        isSubmitting = true;
        const submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...');

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
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Classification created successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("drug-classification.index") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to create classification.',
                        confirmButtonColor: '#dc3545'
                    });
                    isSubmitting = false;
                    submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Save Classification');
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
                    errorMsg = `<ul style="text-align:left; list-style: none; padding: 0; margin: 0;">${errorList}</ul>`;
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Errors',
                        html: errorMsg,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Got it!'
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
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Save Classification');
            }
        });
    });

    // ============================================
    // PREVENT DOUBLE SUBMIT
    // ============================================
    $('form').on('submit', function() {
        if (isSubmitting) {
            return false;
        }
    });

    console.log('✅ Add Drug Classification page loaded successfully!');
});
</script>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 650px; margin: 20px auto; font-size: 13px;">
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
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 650px; margin: 20px auto; font-size: 13px;">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@endsection