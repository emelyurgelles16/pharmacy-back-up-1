@extends('layouts.app')

@php
use App\Models\Setting;
@endphp

@section('title', 'My Profile')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - MY PROFILE
       ============================================ */

    /* ===== HEADER ===== */
    .profile-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        border-radius: 16px;
        padding: 20px 30px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-header h2 i {
        font-size: 24px;
    }

    .profile-header p {
        margin: 4px 0 0 0;
        opacity: 0.85;
        font-size: 14px;
        padding-left: 44px;
    }

    /* ===== PROFILE CARD ===== */
    .profile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid #eef2f6;
    }

    /* ===== SIDEBAR ===== */
    .profile-sidebar {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        padding: 25px 20px;
        text-align: center;
        border-right: 1px solid #e9ecef;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto 16px;
        position: relative;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #0b7a33;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        background: white;
        padding: 3px;
    }

    .avatar-placeholder {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #0b7a33, #056b28);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        border: 3px solid #0b7a33;
        color: white;
        font-size: 56px;
        font-weight: 700;
    }

    .profile-name {
        font-size: 20px;
        font-weight: 700;
        color: #0b7a33;
        margin-bottom: 4px;
    }

    .profile-role {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .profile-info-item {
        text-align: left;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .profile-info-label {
        font-size: 11px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
        font-weight: 600;
    }

    .profile-info-value {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        word-break: break-word;
    }

    .profile-info-value i {
        color: #0b7a33;
        margin-right: 8px;
        width: 20px;
    }

    /* ===== CARD HEADER ===== */
    .card-header-custom {
        background: white;
        padding: 14px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .card-header-custom h4 {
        margin: 0;
        color: #0b7a33;
        font-weight: 700;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-custom h4 i {
        font-size: 20px;
    }

    /* ===== BUTTONS ===== */
    .btn-edit {
        background: #ff9800;
        border: none;
        padding: 8px 22px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 152, 0, 0.4);
        color: white;
    }

    .btn-save {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(11, 122, 51, 0.3);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(11, 122, 51, 0.4);
        color: white;
    }

    .btn-cancel {
        background: #6c757d;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }

    /* ===== FORM ===== */
    .form-group-custom {
        margin-bottom: 18px;
    }

    .form-group-custom label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }

    .form-group-custom label i {
        color: #0b7a33;
        width: 20px;
    }

    .readonly-text {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 14px;
        color: #333;
        font-size: 14px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .readonly-text i {
        color: #0b7a33;
        width: 20px;
    }

    .form-control-custom {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 14px;
        transition: all 0.3s ease;
        background-color: white;
        width: 100%;
        font-size: 14px;
        height: 42px;
    }

    .form-control-custom:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    textarea.form-control-custom {
        height: auto;
        min-height: 60px;
        resize: vertical;
    }

    .form-control-custom::placeholder {
        color: #adb5bd;
        font-size: 13px;
    }

    .edit-mode {
        display: none;
    }

    .action-buttons {
        display: none;
        gap: 12px;
        margin-top: 20px;
        justify-content: flex-end;
        padding-top: 16px;
        border-top: 2px dashed #e9ecef;
    }

    .action-buttons.show {
        display: flex;
    }

    /* ===== FILE INPUT ===== */
    .file-input-wrapper {
        position: relative;
    }

    .file-input-wrapper input[type="file"] {
        display: none;
    }

    .file-input-label {
        background: #e9ecef;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-block;
        color: #0b7a33;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .file-input-label:hover {
        background: #0b7a33;
        color: white;
    }

    .resume-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: #e8f5e9;
        border-radius: 8px;
        color: #0b7a33;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .resume-link:hover {
        background: #0b7a33;
        color: white;
        text-decoration: none;
    }

    .info-badge {
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-radius: 12px;
        padding: 14px 20px;
        margin-top: 20px;
        border-left: 4px solid #0b7a33;
        font-size: 13px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .info-badge i {
        font-size: 16px;
        color: #0b7a33;
        margin-top: 1px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-header {
            padding: 16px 20px;
        }
        .profile-header h2 {
            font-size: 20px;
        }
        .profile-header p {
            padding-left: 0;
            font-size: 13px;
        }
        .profile-sidebar {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
        }
        .avatar-placeholder {
            width: 100px;
            height: 100px;
            font-size: 44px;
        }
        .profile-name {
            font-size: 18px;
        }
        .card-header-custom {
            flex-direction: column;
            align-items: flex-start;
        }
        .action-buttons {
            flex-direction: column;
        }
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
        .info-badge {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .profile-header h2 {
            font-size: 18px;
        }
        .profile-header h2 i {
            font-size: 18px;
        }
        .profile-header p {
            font-size: 12px;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
        }
        .avatar-placeholder {
            width: 80px;
            height: 80px;
            font-size: 36px;
        }
        .profile-name {
            font-size: 16px;
        }
        .profile-role {
            font-size: 13px;
        }
        .profile-info-value {
            font-size: 13px;
        }
        .profile-info-label {
            font-size: 10px;
        }
        .card-header-custom h4 {
            font-size: 16px;
        }
        .card-header-custom h4 i {
            font-size: 18px;
        }
        .form-group-custom label {
            font-size: 12px;
        }
        .form-control-custom {
            font-size: 13px;
            height: 38px;
        }
        .btn-edit {
            font-size: 12px;
            padding: 6px 16px;
        }
        .btn-save,
        .btn-cancel {
            font-size: 13px;
            padding: 8px 20px;
        }
        .readonly-text {
            font-size: 13px;
            padding: 8px 12px;
        }
        .info-badge {
            font-size: 12px;
            padding: 12px 16px;
        }
        .file-input-label {
            font-size: 12px;
            padding: 6px 14px;
        }
        .resume-link {
            font-size: 12px;
            padding: 4px 12px;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- ===== HEADER ===== -->
    <div class="profile-header">
        <h2>
            <i class="fas fa-user-circle"></i>
            My Profile
        </h2>
        <p>Manage your personal information, profile picture, and account security</p>
    </div>

    <div class="row">
        <!-- ===== LEFT SIDEBAR - PROFILE INFO ===== -->
        <div class="col-md-4">
            <div class="profile-card">
                <div class="profile-sidebar">
                    @php
                    $user = auth()->user();
                    $initial = strtoupper(substr($user->full_name ?? $user->username, 0, 1));
                    $photoPath = $user->profile_photo;
                    $photoExists = $photoPath && file_exists(storage_path('app/public/' . $photoPath));
                    $resumePath = $user->resume;
                    $resumeExists = $resumePath && file_exists(storage_path('app/public/' . $resumePath));
                    @endphp

                    @if($photoExists)
                    <div class="profile-avatar view-mode">
                        <img src="{{ asset('storage/' . $photoPath) }}?t={{ time() }}" alt="Profile Photo">
                    </div>
                    @else
                    <div class="avatar-placeholder view-mode">
                        {{ $initial }}
                    </div>
                    @endif

                    <div class="profile-name view-mode">{{ $user->full_name ?? $user->username }}</div>
                    <div class="profile-role view-mode">
                        @php
                        $role = $user->roles->first();
                        @endphp
                        {{ $role ? $role->name : 'No Role Assigned' }}
                    </div>

                    <div class="profile-info-item view-mode">
                        <div class="profile-info-label"><i class="fas fa-envelope"></i> EMAIL</div>
                        <div class="profile-info-value">{{ $user->email ?: 'Not set' }}</div>
                    </div>

                    <div class="profile-info-item view-mode">
                        <div class="profile-info-label"><i class="fas fa-phone"></i> CONTACT NUMBER</div>
                        <div class="profile-info-value">{{ $user->contact_number ?: 'Not set' }}</div>
                    </div>

                    <div class="profile-info-item view-mode">
                        <div class="profile-info-label"><i class="fas fa-map-marker-alt"></i> ADDRESS</div>
                        <div class="profile-info-value">{{ $user->address ?: 'Not set' }}</div>
                    </div>

                    @if($resumeExists)
                    <div class="profile-info-item view-mode">
                        <div class="profile-info-label"><i class="fas fa-file-alt"></i> RESUME</div>
                        <div class="profile-info-value">
                            <a href="{{ route('download.resume', $user->id) }}" target="_blank" class="resume-link">
                                <i class="fas fa-download"></i> View Resume
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="profile-info-item view-mode">
                        <div class="profile-info-label"><i class="fas fa-calendar-alt"></i> MEMBER SINCE</div>
                        <div class="profile-info-value">{{ $user->created_at->format('F d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RIGHT SIDE - EDIT FORM ===== -->
        <div class="col-md-8">
            <div class="profile-card">
                <div class="card-header-custom">
                    <h4>
                        <i class="fas fa-id-card"></i>
                        Profile Information
                    </h4>
                    <button type="button" id="editProfileBtn" class="btn-edit">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>

                <div class="card-body p-4">
                    <form id="profileForm" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- ===== FULL NAME ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-user"></i> Full Name <span class="text-danger">*</span></label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-user"></i> {{ $user->full_name ?? $user->username }}
                            </div>
                            <input type="text" name="full_name" class="form-control-custom edit-mode"
                                value="{{ $user->full_name ?? $user->username }}" required>
                        </div>

                        <!-- ===== EMAIL ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-envelope"></i> {{ $user->email ?: 'Not set' }}
                            </div>
                            <input type="email" name="email" class="form-control-custom edit-mode"
                                value="{{ $user->email }}" placeholder="Enter email address">
                            <small class="text-muted" style="font-size: 12px;">Used for login and communication</small>
                        </div>

                        <!-- ===== CONTACT NUMBER ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-phone-alt"></i> Contact Number</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-phone"></i> {{ $user->contact_number ?: 'Not set' }}
                            </div>
                            <input type="text" name="contact_number" class="form-control-custom edit-mode"
                                value="{{ $user->contact_number }}" placeholder="Enter contact number">
                        </div>

                        <!-- ===== ADDRESS ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-map-marker-alt"></i> Address</label>
                            <div class="readonly-text view-mode">
                                <i class="fas fa-location-dot"></i> {{ $user->address ?: 'Not set' }}
                            </div>
                            <textarea name="address" class="form-control-custom edit-mode" rows="2" placeholder="Enter your address">{{ $user->address }}</textarea>
                        </div>

                        <!-- ===== PROFILE PICTURE ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-image"></i> Profile Picture <span class="text-muted" style="font-size: 12px;">(Optional)</span></label>
                            <div class="readonly-text view-mode">
                                @if($photoExists)
                                <i class="fas fa-check-circle text-success"></i> Photo uploaded
                                @else
                                <i class="fas fa-image"></i> No photo uploaded
                                @endif
                            </div>
                            <div class="edit-mode">
                                <div class="file-input-wrapper">
                                    <label class="file-input-label">
                                        <i class="fas fa-upload"></i> Choose Photo
                                        <input type="file" name="profile_photo" accept="image/jpeg,image/png,image/jpg" id="profilePhotoInput">
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size: 12px;">Recommended: Square image, Max: 2MB (JPG, PNG)</small>
                                @if($photoExists)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $photoPath) }}?t={{ time() }}" alt="Current" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #0b7a33;">
                                    <small class="d-block text-muted" style="font-size: 12px;">Current photo</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- ===== RESUME ===== -->
                        <div class="form-group-custom">
                            <label><i class="fas fa-file-alt"></i> Resume / CV</label>
                            <div class="readonly-text view-mode">
                                @if($resumeExists)
                                <i class="fas fa-file-pdf text-danger"></i>
                                <a href="{{ route('download.resume', $user->id) }}" target="_blank" class="resume-link">
                                    <i class="fas fa-download"></i> View Resume
                                </a>
                                @else
                                <i class="fas fa-file"></i> No resume uploaded
                                @endif
                            </div>
                            <div class="edit-mode">
                                <div class="file-input-wrapper">
                                    <label class="file-input-label">
                                        <i class="fas fa-upload"></i> Upload Resume
                                        <input type="file" name="resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" id="resumeInput">
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size: 12px;">Accepted: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 5MB)</small>
                                @if($resumeExists)
                                <div class="mt-2">
                                    <a href="{{ route('download.resume', $user->id) }}" target="_blank" class="btn btn-sm btn-outline-success" style="font-size: 13px; padding: 4px 12px; border-radius: 6px;">
                                        <i class="fas fa-eye"></i> View Current Resume
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- ===== CHANGE PASSWORD ===== -->
                        <hr class="my-4">
                        <h5 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 12px;">
                            <i class="fas fa-lock" style="color: #0b7a33;"></i> Change Password
                        </h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <label><i class="fas fa-key"></i> New Password</label>
                                    <input type="password" name="password" class="form-control-custom edit-mode"
                                        placeholder="Leave blank to keep current password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group-custom">
                                    <label><i class="fas fa-check-circle"></i> Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control-custom edit-mode"
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        <!-- ===== INFO BADGE ===== -->
                        <div class="info-badge">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Security Tip:</strong> Use a strong password with at least 8 characters including letters, numbers, and symbols.
                            </div>
                        </div>

                        <!-- ===== ACTION BUTTONS ===== -->
                        <div id="profileActions" class="action-buttons">
                            <button type="button" id="cancelProfileBtn" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let isEditMode = false;

    // ============================================
    // TOGGLE EDIT MODE
    // ============================================
    $('#editProfileBtn').on('click', function() {
        if (!isEditMode) {
            isEditMode = true;
            $('.view-mode').hide();
            $('.edit-mode').show();
            $('#profileActions').addClass('show');
            $(this).html('<i class="fas fa-times"></i> Cancel Edit');
            $(this).removeClass('btn-edit').addClass('btn-cancel');

            Swal.fire({
                icon: 'info',
                title: 'Edit Mode Enabled',
                text: 'You can now edit your profile information.',
                confirmButtonColor: '#0b7a33',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            cancelEdit();
        }
    });

    // ============================================
    // CANCEL EDIT
    // ============================================
    $('#cancelProfileBtn').on('click', function() {
        cancelEdit();
    });

    function cancelEdit() {
        isEditMode = false;
        $('.view-mode').show();
        $('.edit-mode').hide();
        $('#profileActions').removeClass('show');
        $('#editProfileBtn').html('<i class="fas fa-edit"></i> Edit Profile');
        $('#editProfileBtn').removeClass('btn-cancel').addClass('btn-edit');

        $('#profileForm')[0].reset();

        Swal.fire({
            icon: 'info',
            title: 'Edit Cancelled',
            text: 'Changes were discarded.',
            confirmButtonColor: '#0b7a33',
            timer: 2000,
            showConfirmButton: false
        });
    }

    // ============================================
    // PROFILE PHOTO PREVIEW
    // ============================================
    $('#profilePhotoInput').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.edit-mode .profile-avatar img').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // ============================================
    // RESUME VALIDATION
    // ============================================
    $('#resumeInput').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var validTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png',
                'image/jpg'
            ];
            if (!validTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please upload PDF, DOC, DOCX, JPG, or PNG file only.',
                    confirmButtonColor: '#d33'
                });
                $(this).val('');
            } else if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Please upload a file smaller than 5MB.',
                    confirmButtonColor: '#d33'
                });
                $(this).val('');
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'File Selected',
                    text: file.name + ' is ready to upload.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        }
    });

    // ============================================
    // FORM SUBMIT
    // ============================================
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we update your profile.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '{{ route("settings.update-profile") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Profile updated successfully!',
                    confirmButtonColor: '#0b7a33'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                let errorMsg = 'Something went wrong!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMsg,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script>
@endsection