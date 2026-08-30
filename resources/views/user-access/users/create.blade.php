@extends('layouts.app')

@section('title', 'Add New Employee')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);">
                <div class="card-body">
                    <div>
                        <h4 class="mb-1 text-white">
                            <i class="fas fa-user-plus me-2"></i> Add New Employee
                        </h4>
                        <p class="mb-0 text-white-50">Create a new employee account</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="createEmployeeForm" action="/users" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small id="passwordMatchMsg" class="text-muted"></small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control">
                        <small class="text-muted">Optional</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Optional"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select" required>
                            <option value="Admin">Admin</option>
                            <option value="Cashier" selected>Cashier</option>
                            <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                            <option value="Pharmacist">Pharmacist</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- DOCUMENTS SECTION -->
                    <div class="col-12">
                        <hr class="my-3">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="fas fa-file-alt me-2"></i> Employee Documents
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Resume / CV</label>
                        <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Photo</label>
                        <input type="file" name="id_photo" class="form-control" accept="image/*">
                        <small class="text-muted">JPG, PNG (Max 2MB)</small>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4" id="submitBtn">
                        <i class="fas fa-save me-2"></i> Create Employee
                    </button>
                    <a href="{{ route('user-access.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Real-time password match checking
const password = document.getElementById('password');
const confirmPassword = document.getElementById('password_confirmation');
const matchMsg = document.getElementById('passwordMatchMsg');

function checkPasswordMatch() {
    if (confirmPassword.value.length > 0) {
        if (password.value === confirmPassword.value) {
            matchMsg.innerHTML = '✓ Passwords match!';
            matchMsg.style.color = 'green';
            return true;
        } else {
            matchMsg.innerHTML = '✗ Passwords do not match!';
            matchMsg.style.color = 'red';
            return false;
        }
    } else {
        matchMsg.innerHTML = '';
        return true;
    }
}

password.addEventListener('input', checkPasswordMatch);
confirmPassword.addEventListener('input', checkPasswordMatch);

</script>
@endsection