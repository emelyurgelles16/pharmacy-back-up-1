@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);">
                <div class="card-body">
                    <div>
                        <h4 class="mb-1 text-white">
                            <i class="fas fa-user-edit me-2"></i> Edit Employee
                        </h4>
                        <p class="mb-0 text-white-50">Update employee information</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="editEmployeeForm" action="{{ route('user-access.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                               value="{{ old('full_name', $user->full_name) }}" required>
                        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username', $user->username) }}" required>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control" 
                               value="{{ old('contact_number', $user->contact_number) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
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
                        @if($user->resume)
                        <div class="mt-2">
                            @php
                                $resumeExt = pathinfo($user->resume, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array($resumeExt, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $user->resume) }}" alt="Resume Image" style="max-height: 80px; border: 1px solid #ddd; border-radius: 4px;">
                            @else
                                <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="text-success">
                                    <i class="fas fa-file-pdf me-1"></i> View Current Resume
                                </a>
                            @endif
                            <br>
                            <small class="text-muted">Upload new file to replace</small>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Photo</label>
                        <input type="file" name="id_photo" class="form-control" accept="image/*">
                        <small class="text-muted">JPG, PNG (Max 2MB)</small>
                        @if($user->id_photo)
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $user->id_photo) }}" target="_blank" class="text-success">
                                <i class="fas fa-id-card me-1"></i> View Current ID Photo
                            </a>
                            <br>
                            <small class="text-muted">Upload new file to replace</small>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4" id="submitBtn">
                        <i class="fas fa-save me-2"></i> Update Employee
                    </button>
                    <a href="{{ route('user-access.index') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i> Updating...';
    
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message || 'Employee updated successfully!',
                confirmButtonColor: '#0b8f66',
                timer: 2000,
                showConfirmButton: true
            }).then(() => {
                window.location.href = '{{ route('user-access.index') }}';
            });
        } else {
            let errorMessage = data.message || 'Failed to update employee.';
            if (data.errors) {
                errorMessage = Object.values(data.errors).flat().join('\n');
            }
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
                confirmButtonColor: '#d33'
            });
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#d33'
        });
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});
</script>
@endsection