@extends('layouts.app')

@section('title', 'Add New Employee')

@section('content')
<style>
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    .form-header {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        color: white;
    }
    .form-header h4 {
        margin: 0;
        font-size: 16px;
    }
    .form-header p {
        margin: 2px 0 0 0;
        opacity: 0.8;
        font-size: 12px;
    }
    .form-body {
        background: white;
        padding: 15px 20px;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
        font-size: 12px;
        color: #333;
        margin-bottom: 2px;
    }
    .form-label .required {
        color: #dc3545;
        margin-left: 2px;
    }
    .form-control, .form-select {
        border-radius: 5px;
        padding: 5px 10px;
        border: 1.5px solid #e0e0e0;
        transition: all 0.3s ease;
        font-size: 13px;
        height: 34px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 2px rgba(11, 122, 51, 0.1);
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
    }
    .form-control.is-valid {
        border-color: #28a745;
    }
    .section-divider {
        border-top: 1px solid #e8f5e9;
        margin: 10px 0;
    }
    .section-title {
        font-size: 13px;
        font-weight: 600;
        color: #1b5e20;
        margin-bottom: 8px;
    }
    .section-title i {
        margin-right: 5px;
    }
    .btn-submit {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        color: white;
        padding: 6px 22px;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(11, 122, 51, 0.3);
    }
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    .btn-cancel {
        background: #f0f0f0;
        color: #666;
        padding: 6px 18px;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .btn-cancel:hover {
        background: #e0e0e0;
        color: #333;
        text-decoration: none;
    }
    .avatar-preview {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #f8f9fa;
        border: 2px dashed #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #ccc;
        margin: 0 auto;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
    }
    .avatar-preview:hover {
        border-color: #0b7a33;
        background: #f1f8e9;
    }
    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-preview.has-image {
        border-color: #0b7a33;
        border-style: solid;
    }
    .avatar-upload-wrapper {
        text-align: center;
        margin-bottom: 10px;
    }
    .avatar-upload-wrapper small {
        display: block;
        margin-top: 3px;
        color: #999;
        font-size: 10px;
    }
    .avatar-input {
        display: none;
    }
    .form-hint {
        font-size: 10px;
        color: #999;
        margin-top: 2px;
    }
    .password-match-success {
        color: #28a745;
        font-size: 11px;
        margin-top: 2px;
    }
    .password-match-error {
        color: #dc3545;
        font-size: 11px;
        margin-top: 2px;
    }
    .role-option {
        padding: 6px 10px;
        border: 1.5px solid #e0e0e0;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        height: 100%;
    }
    .role-option:hover {
        border-color: #0b7a33;
        background: #f8f9fa;
    }
    .role-option.selected {
        border-color: #0b7a33;
        background: #e8f5e9;
        box-shadow: 0 0 0 2px rgba(11, 122, 51, 0.1);
    }
    .role-option input[type="radio"] {
        display: none;
    }
    .role-option .role-icon {
        font-size: 18px;
        flex-shrink: 0;
    }
    .role-option .role-name {
        font-weight: 600;
        font-size: 12px;
    }
    .role-option .role-desc {
        font-size: 10px;
        color: #666;
    }
    .status-switch {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 3px 0;
    }
    .status-switch .form-check-input {
        width: 36px;
        height: 20px;
        cursor: pointer;
        margin: 0;
    }
    .status-switch .form-check-input:checked {
        background-color: #0b7a33;
        border-color: #0b7a33;
    }
    .status-switch .status-label {
        font-weight: 500;
        font-size: 12px;
        margin: 0;
    }
    .status-switch .status-label.active {
        color: #0b7a33;
    }
    .status-switch .status-label.inactive {
        color: #dc3545;
    }
    .status-switch .text-muted {
        font-size: 11px;
    }
    .mb-1 {
        margin-bottom: 6px !important;
    }
    .mb-2 {
        margin-bottom: 8px !important;
    }
    .mb-3 {
        margin-bottom: 10px !important;
    }
    .mt-2 {
        margin-top: 8px !important;
    }
    .mt-3 {
        margin-top: 10px !important;
    }
    .gap-1 {
        gap: 4px !important;
    }
    .gap-2 {
        gap: 8px !important;
    }
    .pt-2 {
        padding-top: 8px !important;
    }
    .invalid-feedback {
        font-size: 11px;
        color: #dc3545;
        margin-top: 2px;
    }
    .input-group .btn {
        border-radius: 0 5px 5px 0;
        padding: 5px 10px;
        font-size: 13px;
    }
    .input-group .form-control {
        border-radius: 5px 0 0 5px;
    }
    .btn-outline-secondary {
        padding: 5px 10px;
    }
    .btn-outline-secondary i {
        font-size: 13px;
    }
    .row.g-1 {
        --bs-gutter-y: 4px;
        --bs-gutter-x: 6px;
    }
    /* Responsive */
    @media (max-width: 768px) {
        .form-body {
            padding: 10px 12px;
        }
        .role-option {
            padding: 5px 8px;
        }
        .role-option .role-icon {
            font-size: 16px;
        }
        .role-option .role-desc {
            display: none;
        }
        .role-option .role-name {
            font-size: 11px;
        }
    }
</style>

<div class="container-fluid form-container">
    <!-- Header -->
    <div class="form-header">
        <h4><i class="fas fa-user-plus me-1"></i> Add New Employee</h4>
        <p>Fill in the details below to create a new employee account</p>
    </div>

    <!-- Form Body -->
    <div class="form-body">
        <form id="createEmployeeForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ===== PROFILE PICTURE ===== -->
            <div class="avatar-upload-wrapper">
                <div class="avatar-preview" id="avatarPreview">
                    <i class="fas fa-user"></i>
                </div>
                <small>Click to upload profile picture</small>
                <input type="file" name="profile_picture" id="profilePicture" class="avatar-input" accept="image/*">
            </div>

            <!-- ===== PERSONAL INFORMATION ===== -->
            <div class="section-title">
                <i class="fas fa-user-circle text-success"></i> Personal Information
            </div>

            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <label class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                           placeholder="Enter full name" value="{{ old('full_name') }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label">Username <span class="required">*</span></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                           placeholder="Enter username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <label class="form-label">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Enter email address" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                           placeholder="Enter contact number" value="{{ old('contact_number') }}">
                    @error('contact_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-1">
                <div class="col-md-12 mb-1">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                              rows="1" placeholder="Enter address (optional)" style="height: 32px; padding: 4px 10px;">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ===== DIVIDER ===== -->
            <div class="section-divider"></div>

            <!-- ===== ACCOUNT INFORMATION ===== -->
            <div class="section-title">
                <i class="fas fa-lock text-success"></i> Account Information
            </div>

            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Enter password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-hint">Minimum 8 characters</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label">Confirm Password <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                               placeholder="Confirm password" required>
                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="passwordMatchMsg"></div>
                </div>
            </div>

            <!-- ===== DIVIDER ===== -->
            <div class="section-divider"></div>

            <!-- ===== ROLE SELECTION ===== -->
            <div class="section-title">
                <i class="fas fa-user-tag text-success"></i> Assign Role <span class="required">*</span>
            </div>

            <div class="row g-1 mb-1">
                @php
                    $roles = [
                        'Admin' => ['icon' => '👑', 'desc' => 'Full access'],
                        'Cashier' => ['icon' => '💰', 'desc' => 'POS & payments'],
                        'Pharmacy Assistant' => ['icon' => '📦', 'desc' => 'Inventory'],
                        'Pharmacist' => ['icon' => '💊', 'desc' => 'Prescriptions']
                    ];
                @endphp
                @foreach($roles as $roleName => $roleData)
                <div class="col-md-3 col-sm-6">
                    <label class="role-option @if(old('role', 'Cashier') == $roleName) selected @endif">
                        <input type="radio" name="role" value="{{ $roleName }}" 
                               @if(old('role', 'Cashier') == $roleName) checked @endif>
                        <div class="role-icon">{{ $roleData['icon'] }}</div>
                        <div>
                            <div class="role-name">{{ $roleName }}</div>
                            <div class="role-desc">{{ $roleData['desc'] }}</div>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            @error('role')
                <div class="text-danger" style="font-size: 11px; margin-top: -3px; margin-bottom: 6px;">{{ $message }}</div>
            @enderror

            <!-- ===== DIVIDER ===== -->
            <div class="section-divider"></div>

            <!-- ===== DOCUMENTS ===== -->
            <div class="section-title">
                <i class="fas fa-file-alt text-success"></i> Documents (Optional)
            </div>

            <div class="row g-1">
                <div class="col-md-6 mb-1">
                    <label class="form-label">Resume / CV</label>
                    <input type="file" name="resume" class="form-control @error('resume') is-invalid @enderror" 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="height: 34px; padding: 2px 8px;">
                    <div class="form-hint">PDF, DOC, DOCX, JPG, PNG (Max 5MB)</div>
                    @error('resume')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-1">
                    <label class="form-label">ID Photo</label>
                    <input type="file" name="id_photo" class="form-control @error('id_photo') is-invalid @enderror" 
                           accept="image/*" style="height: 34px; padding: 2px 8px;">
                    <div class="form-hint">JPG, PNG (Max 2MB)</div>
                    @error('id_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- ===== DIVIDER ===== -->
            <div class="section-divider"></div>

            <!-- ===== ACCOUNT STATUS ===== -->
            <div class="section-title">
                <i class="fas fa-toggle-on text-success"></i> Account Status
            </div>

            <div class="status-switch">
                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                <span class="status-label active" id="statusLabel">Active</span>
                <span class="text-muted">(User can login immediately)</span>
            </div>

            <!-- ===== BUTTONS ===== -->
            <div class="d-flex justify-content-end gap-1 mt-2 pt-2" style="border-top: 1px solid #e8e8e8;">
                <a href="{{ route('user-access.index') }}" class="btn-cancel">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save me-1"></i> Create
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Profile Picture Preview
    $('#profilePicture').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').html('<img src="' + e.target.result + '" alt="Profile">');
                $('#avatarPreview').addClass('has-image');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#avatarPreview').on('click', function() {
        $('#profilePicture').click();
    });

    // Role Selection
    $('.role-option').on('click', function() {
        $('.role-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Toggle Password
    $('.toggle-password').on('click', function() {
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

    // Password Match
    function checkPasswordMatch() {
        const password = $('#password').val();
        const confirm = $('#password_confirmation').val();
        const msgDiv = $('#passwordMatchMsg');
        
        if (confirm.length > 0) {
            if (password === confirm) {
                msgDiv.html('<span class="password-match-success"><i class="fas fa-check-circle me-1"></i> Passwords match!</span>');
                $('#password_confirmation').removeClass('is-invalid').addClass('is-valid');
                return true;
            } else {
                msgDiv.html('<span class="password-match-error"><i class="fas fa-times-circle me-1"></i> Passwords do not match!</span>');
                $('#password_confirmation').removeClass('is-valid').addClass('is-invalid');
                return false;
            }
        } else {
            msgDiv.html('');
            $('#password_confirmation').removeClass('is-valid is-invalid');
            return true;
        }
    }

    $('#password, #password_confirmation').on('keyup', checkPasswordMatch);

    // Status Toggle
    $('#isActive').on('change', function() {
        const label = $('#statusLabel');
        if ($(this).is(':checked')) {
            label.text('Active').removeClass('inactive').addClass('active');
        } else {
            label.text('Inactive').removeClass('active').addClass('inactive');
        }
    });

    // Form Submit
    $('#createEmployeeForm').on('submit', function(e) {
        if (!checkPasswordMatch()) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Please make sure your passwords match.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
                heightAuto: false
            });
            return false;
        }
        
        $('#submitBtn').prop('disabled', true);
        $('#submitBtn').html('<i class="fas fa-spinner fa-spin me-1"></i> Creating...');
    });
});
</script>
@endsection