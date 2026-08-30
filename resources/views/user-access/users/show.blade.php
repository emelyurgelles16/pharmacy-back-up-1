@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-white">
                                <i class="fas fa-user-circle me-2"></i> Employee Details
                            </h4>
                            <p class="mb-0 text-white-50">View employee information</p>
                        </div>
                        <div>
                            <a href="{{ route('user-access.edit', $user) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('user-access.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Profile Image -->
                <div class="col-md-3 text-center mb-4">
                    @if($user->id_photo)
                        <img src="{{ asset('storage/' . $user->id_photo) }}" alt="Profile Photo" 
                             class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #0b7a33;">
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 150px; height: 150px; font-size: 60px; color: white;">
                            {{ strtoupper(substr($user->full_name ?? $user->username, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="mt-3">{{ $user->full_name ?? $user->username }}</h5>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">ID:</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>Full Name:</th>
                                    <td><strong>{{ $user->full_name ?? $user->username }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Username:</th>
                                    <td><code>{{ $user->username }}</code></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Status:</th>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Contact Number:</th>
                                    <td>{{ $user->contact_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $user->address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Joined:</th>
                                    <td>{{ $user->created_at->format('F d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <hr>
                            <h6 class="fw-bold text-success"><i class="fas fa-file-alt me-2"></i> Documents</h6>
                        </div>
                        <div class="col-md-6">
                            <strong>Resume / CV:</strong>
                            @if($user->resume)
                                @php
                                    $resumeExt = pathinfo($user->resume, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array($resumeExt, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $user->resume) }}" alt="Resume" style="max-height: 100px; border: 1px solid #ddd; border-radius: 4px;">
                                @else
                                    <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="text-success">
                                        <i class="fas fa-file-pdf me-1"></i> View Resume
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">No resume uploaded</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>ID Photo:</strong>
                            @if($user->id_photo)
                                <a href="{{ asset('storage/' . $user->id_photo) }}" target="_blank" class="text-success">
                                    <i class="fas fa-id-card me-1"></i> View ID Photo
                                </a>
                            @else
                                <span class="text-muted">No ID photo uploaded</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection