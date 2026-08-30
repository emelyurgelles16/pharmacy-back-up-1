@extends('layouts.app')

@section('title', 'Categories - Pharmacy System')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="header-box">
        <h2><i class="fa-solid fa-tags"></i> Categories Management</h2>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <!-- Search -->
            <div style="display: flex; align-items: center;">
                <label>Search:</label>
                <input type="text" id="searchBox" placeholder="Search category name...">
            </div>
        </div>

        <div class="toolbar-right">
            <!-- Add Category Button -->
            <button id="addCategoryBtn">
                <i class="fa-solid fa-plus"></i> Add New Category
            </button>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card shadow mb-4 border-heal">
        <div class="card-header bg-heal text-white py-3">
            <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list"></i> All Categories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="categoriesTable" width="100%" cellspacing="0">
                    <thead class="table-heal">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        @forelse($categories as $category)
                        <tr id="category-{{ $category->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->description ?? 'No description' }}</td>
                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                            <td class="actions-col">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-heal-edit btn-edit" 
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-description="{{ $category->description }}">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-heal-delete btn-delete" data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fa-solid fa-inbox fa-2x mb-2" style="color: #2e7d32;"></i><br>
                                No categories found. Add your first category!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-heal">
            <div class="modal-header bg-heal text-white">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add New Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCategoryForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-heal" id="name" name="name" required 
                               placeholder="Enter category name (e.g., Antibiotics, Vitamins)">
                        <div class="form-text">Category name must be unique.</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control border-heal" id="description" name="description" 
                                  rows="3" placeholder="Enter category description (optional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-heal">
                        <i class="fa-solid fa-plus"></i> Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-heal-edit">
            <div class="modal-header bg-heal-edit text-white">
                <h5 class="modal-title"><i class="fa-solid fa-edit"></i> Edit Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-heal-edit" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control border-heal-edit" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-heal-edit">
                        <i class="fa-solid fa-save"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- POS Style Notification -->
<div id="notification" style="position: fixed; top: 18px; right: 18px; padding: 12px 16px; border-radius: 10px; color: #fff; display: none; z-index: 2000; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12); font-weight: 600;"></div>

<style>
/* === Header Box === */
.header-box {
    background: #056b28;
    color: #fff;
    padding: 20px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.header-box h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.header-box h2 i {
    margin-right: 10px;
}

/* === Toolbar === */
.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.toolbar-left {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.toolbar label {
    margin-right: 8px;
    font-weight: 500;
    color: #333;
    white-space: nowrap;
}

.toolbar select,
.toolbar input,
.toolbar button {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    outline: none;
    height: 40px;
    box-sizing: border-box;
}

.toolbar input {
    width: 250px;
}

.toolbar button {
    background: #1b5e20;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 500;
    white-space: nowrap;
}

.toolbar button:hover {
    background: #2e7d32;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(27, 94, 32, 0.3);
}

/* Healing Green Color Scheme */
:root {
    --heal-green: #2e7d32;
    --heal-green-light: #4caf50;
    --heal-green-dark: #1b5e20;
    --heal-edit: #ff9800;
    --heal-edit-light: #ffb74d;
    --heal-edit-dark: #f57c00;
    --heal-delete: #d32f2f;
    --heal-delete-light: #ef5350;
    --heal-delete-dark: #c62828;
}

/* Button Styles */
.btn-heal {
    background-color: var(--heal-green);
    border-color: var(--heal-green);
    color: white;
}

.btn-heal:hover {
    background-color: var(--heal-green-dark);
    border-color: var(--heal-green-dark);
    color: white;
}

.btn-heal-edit {
    background-color: var(--heal-edit);
    border-color: var(--heal-edit);
    color: white;
}

.btn-heal-edit:hover {
    background-color: var(--heal-edit-dark);
    border-color: var(--heal-edit-dark);
    color: white;
}

.btn-heal-delete {
    background-color: var(--heal-delete);
    border-color: var(--heal-delete);
    color: white;
}

.btn-heal-delete:hover {
    background-color: var(--heal-delete-dark);
    border-color: var(--heal-delete-dark);
    color: white;
}

/* Background Colors */
.bg-heal {
    background-color: var(--heal-green) !important;
}

.bg-heal-edit {
    background-color: var(--heal-edit) !important;
}

/* Border Colors */
.border-heal {
    border-color: var(--heal-green) !important;
}

.border-heal-edit {
    border-color: var(--heal-edit) !important;
}

/* Table Styles */
.table-heal {
    background-color: var(--heal-green);
    color: white;
}

.table-heal th {
    border-bottom: 2px solid var(--heal-green-dark);
    font-weight: 600;
}

/* Hover Effects */
.table-hover tbody tr:hover {
    background-color: rgba(46, 125, 50, 0.08);
    transform: translateY(1px);
    transition: all 0.2s ease;
}

/* Form Control Focus */
.form-control.border-heal:focus,
.form-control.border-heal-edit:focus {
    box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    border-color: var(--heal-green);
}

.form-control.border-heal-edit:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
    border-color: var(--heal-edit);
}

/* Card Styling */
.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Button Group Styling */
.btn-group .btn {
    margin-right: 5px;
    border-radius: 6px;
    font-weight: 500;
}

/* Modal Styling */
.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

/* Code Styling */
code {
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    color: var(--heal-green-dark);
    font-size: 0.875em;
}

/* Actions Column */
.actions-col {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
}

/* Table Alignment */
table td, table th {
    text-align: center;
    vertical-align: middle !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-group .btn {
        margin-right: 0;
    }

    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .toolbar-left, .toolbar-right {
        justify-content: center;
    }

    .toolbar input {
        width: 200px;
    }
}

@media (max-width: 480px) {
    .header-box {
        padding: 15px 20px;
    }

    .header-box h2 {
        font-size: 20px;
    }

    .toolbar input {
        width: 150px;
    }
}
</style>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============================================
// AUTO CAPITALIZE FIRST LETTER
// ============================================
function capitalizeFirstLetter(input) {
    if (input && input.value && input.value.length > 0) {
        let value = input.value;
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
    }
}

// Search functionality
document.getElementById('searchBox').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    
    document.querySelectorAll('#categoriesTableBody tr').forEach(row => {
        const categoryName = row.children[1].textContent.toLowerCase();
        const categorySlug = row.children[2].textContent.toLowerCase();
        const categoryDesc = row.children[3].textContent.toLowerCase();
        
        const matches = categoryName.includes(searchTerm) || 
                       categorySlug.includes(searchTerm) || 
                       categoryDesc.includes(searchTerm);
        
        row.style.display = matches ? '' : 'none';
    });
});

// POS Style Notification Function with Healing Green Theme
function showNotification(msg, type = 'success') {
    const el = document.getElementById('notification');
    el.textContent = msg;
    el.style.display = 'block';
    
    switch(type) {
        case 'created':
            el.style.background = 'var(--heal-green)';
            el.innerHTML = '<i class="fa-solid fa-circle-plus"></i> ' + msg;
            break;
        case 'updated':
            el.style.background = 'var(--heal-edit)';
            el.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> ' + msg;
            break;
        case 'deleted':
            el.style.background = 'var(--heal-delete)';
            el.innerHTML = '<i class="fa-solid fa-trash"></i> ' + msg;
            break;
        case 'error':
            el.style.background = 'var(--heal-delete-dark)';
            el.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + msg;
            break;
        case 'warning':
            el.style.background = 'var(--heal-edit-dark)';
            el.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + msg;
            break;
        default:
            el.style.background = 'var(--heal-green)';
            el.innerHTML = '<i class="fa-solid fa-check-circle"></i> ' + msg;
    }
    
    setTimeout(() => {
        el.style.opacity = 1;
        el.style.transition = 'opacity 0.3s ease';
    }, 20);
    
    setTimeout(() => {
        el.style.opacity = 0;
        setTimeout(() => el.style.display = 'none', 300);
    }, 2200);
}

// Refresh categories table
function refreshCategoriesTable() {
    fetch('{{ route("categories.index") }}')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableBody = doc.querySelector('#categoriesTableBody');
            if (newTableBody) {
                document.getElementById('categoriesTableBody').innerHTML = newTableBody.innerHTML;
                attachEventListeners();
            }
        })
        .catch(error => {
            console.error('Error refreshing table:', error);
            showNotification('Error refreshing table', 'error');
        });
}

// Attach event listeners to edit and delete buttons
function attachEventListeners() {
    // Edit Category
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const description = this.getAttribute('data-description');
            
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description || '';
            
            new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
        });
    });

    // Delete Category
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete category: ${name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--heal-delete)',
                cancelButtonColor: 'var(--heal-green)',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                iconColor: 'var(--heal-delete)'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCategory(id, name);
                }
            });
        });
    });
}

// Open Add Modal
function openAddModal() {
    document.getElementById('addCategoryForm').reset();
    new bootstrap.Modal(document.getElementById('addCategoryModal')).show();
}

// Add Category Button Event Listener
document.getElementById('addCategoryBtn').addEventListener('click', openAddModal);

// ============================================
// ADD CATEGORY
// ============================================
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // ✅ Auto capitalize before submit
    const nameInput = document.getElementById('name');
    capitalizeFirstLetter(nameInput);
    
    const formData = new FormData(this);
    
    fetch('{{ route("categories.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
            showNotification(data.message || 'Category created successfully!', 'created');
            refreshCategoriesTable();
            document.getElementById('searchBox').value = '';
        } else {
            showNotification(data.message || 'Error adding category', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding category', 'error');
    });
});

// ============================================
// EDIT CATEGORY
// ============================================
document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // ✅ Auto capitalize before submit
    const nameInput = document.getElementById('edit_name');
    capitalizeFirstLetter(nameInput);
    
    const id = document.getElementById('edit_id').value;
    const formData = new FormData(this);
    
    fetch(`/categories/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'PUT'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('editCategoryModal')).hide();
            showNotification(data.message || 'Category updated successfully!', 'updated');
            refreshCategoriesTable();
        } else {
            showNotification(data.message || 'Error updating category', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating category', 'error');
    });
});

// ============================================
// DELETE CATEGORY
// ============================================
function deleteCategory(id, name) {
    fetch(`/categories/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'DELETE'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification(data.message || `Category "${name}" deleted successfully!`, 'deleted');
            refreshCategoriesTable();
            document.getElementById('searchBox').value = '';
        } else {
            showNotification(data.message || 'Error deleting category', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting category', 'error');
    });
}

// ============================================
// AUTO CAPITALIZE - REAL-TIME
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();
    document.getElementById('searchBox').value = '';
    
    // Add modal - auto capitalize
    const addNameInput = document.getElementById('name');
    if (addNameInput) {
        addNameInput.addEventListener('input', function() { 
            capitalizeFirstLetter(this); 
        });
        addNameInput.addEventListener('blur', function() { 
            capitalizeFirstLetter(this); 
        });
    }
    
    // Edit modal - auto capitalize
    const editNameInput = document.getElementById('edit_name');
    if (editNameInput) {
        editNameInput.addEventListener('input', function() { 
            capitalizeFirstLetter(this); 
        });
        editNameInput.addEventListener('blur', function() { 
            capitalizeFirstLetter(this); 
        });
    }
});

// Clear search when page loads to show all categories
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchBox').value = '';
});
</script>
@endsection