@extends('layouts.app')

@section('title', 'Categories - Pharmacy System')

@section('content')

<style>
/* === Header Box === */
.header-box {
    background: #056b28;
    color: #fff;
    padding: 20px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    text-align: left;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.header-box h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
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
    font-weight: 600;
    color: #333;
    white-space: nowrap;
    font-size: 13px;
}

.toolbar select,
.toolbar input,
.toolbar button {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 13px;
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

/* ============================================================ */
/* TABLE WITH BORDER LINES - NO SHADOW */
/* ============================================================ */
.table-heal {
    background-color: var(--heal-green);
    color: white;
}

.table-heal th {
    border: 1px solid #1b5e20 !important;
    font-weight: 600;
    font-size: 13px;
    padding: 12px 10px;
    text-align: center;
    vertical-align: middle;
}

.table-heal th:first-child {
    border-left: 1px solid #1b5e20 !important;
}

.table-heal th:last-child {
    border-right: 1px solid #1b5e20 !important;
}

/* Table Cells with Borders */
#categoriesTable {
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #dee2e6;
}

#categoriesTable thead th {
    border: 1px solid #1b5e20;
    background-color: var(--heal-green);
    color: white;
    padding: 12px 10px;
    text-align: center;
    vertical-align: middle;
    font-size: 13px;
    font-weight: 600;
}

#categoriesTable tbody td {
    border: 1px solid #dee2e6;
    padding: 10px 12px;
    text-align: center;
    vertical-align: middle;
    font-size: 13px;
}

#categoriesTable tbody tr:hover {
    background-color: rgba(46, 125, 50, 0.08);
    transition: all 0.2s ease;
}

#categoriesTable tbody tr:nth-child(even) {
    background-color: #fafffa;
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

/* Card Styling - NO SHADOW */
.card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: none !important;
    border: 1px solid #dee2e6;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.card-header h6 {
    font-size: 15px;
    font-weight: 600;
}

/* Button Group Styling */
.btn-group .btn {
    margin-right: 5px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    padding: 6px 14px;
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

.modal-title {
    font-size: 18px;
    font-weight: 600;
}

.modal-body .form-label {
    font-size: 13px;
    font-weight: 500;
}

/* Code Styling */
code {
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    color: var(--heal-green-dark);
    font-size: 12px;
    font-family: monospace;
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

table td {
    font-size: 13px;
}

/* ============================================================ */
/* PAGINATION - TULAD NG NASA PICTURE */
/* ============================================================ */
.pagination-wrapper {
    padding: 12px 18px;
    background: #fafbfc;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    border-radius: 0 0 10px 10px;
}

.pagination-wrapper .pagination-info {
    font-size: 14px;
    color: #495057;
    font-weight: 500;
}

.pagination-wrapper .pagination-info strong {
    color: #1b5e20;
    font-weight: 700;
}

.pagination {
    display: flex;
    gap: 4px;
    margin: 0;
    padding: 0;
    list-style: none;
    align-items: center;
}

.pagination .page-item {
    display: inline-block;
}

.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    color: #495057;
    background: white;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.pagination .page-link:hover {
    background: #e8f5e9;
    border-color: #1b5e20;
    color: #1b5e20;
}

.pagination .page-item.active .page-link {
    background: #1b5e20;
    border-color: #1b5e20;
    color: white;
    font-weight: 700;
}

.pagination .page-item.disabled .page-link {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.pagination .page-link i {
    font-size: 12px;
}

/* ============================================================ */
/* SUCCESS MODAL - NO BLUR BACKGROUND */
/* ============================================================ */
.modal-success-overlay {
    display: none;
    position: fixed;
    z-index: 99999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modal-success-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 35px 40px;
    border-radius: 16px;
    width: 420px;
    max-width: 92%;
    max-height: 90vh;
    overflow-y: auto;
    z-index: 100000;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.3s ease;
    text-align: center;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

.modal-success-content .success-icon {
    font-size: 60px;
    color: #2e7d32;
    margin-bottom: 12px;
}

.modal-success-content .success-icon .fa-circle-check {
    color: #2e7d32;
}

.modal-success-content h3 {
    font-size: 22px;
    font-weight: 700;
    color: #1b5e20;
    margin-bottom: 8px;
}

.modal-success-content p {
    font-size: 14px;
    color: #555;
    margin-bottom: 22px;
}

.modal-success-content .btn-success-modal {
    background: #2e7d32;
    color: white;
    border: none;
    padding: 10px 40px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-success-content .btn-success-modal:hover {
    background: #1b5e20;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(27, 94, 32, 0.3);
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

    .modal-success-content {
        padding: 25px 20px;
        width: 95%;
    }

    .pagination-wrapper {
        flex-direction: column;
        align-items: center;
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
                <label><i class="fa-solid fa-search"></i> Search:</label>
                <input type="text" id="searchBox" placeholder="Type to search categories..." autofocus>
            </div>
        </div>

        <div class="toolbar-right">
            <!-- Add Category Button -->
            <button id="addCategoryBtn">
                <i class="fa-solid fa-plus"></i> Add New Category
            </button>
        </div>
    </div>

    <!-- Categories Table WITH BORDER LINES - NO SHADOW -->
    <div class="card border-heal" style="box-shadow: none !important; border: 1px solid #dee2e6;">
        <div class="card-header bg-heal text-white py-3" style="border-radius: 10px 10px 0 0;">
            <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list"></i> All Categories</h6>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="categoriesTable" width="100%" cellspacing="0" style="border-collapse: collapse; border: 1px solid #dee2e6; margin-bottom: 0;">
                    <thead class="table-heal">
                        <tr>
                            <th width="5%" style="border: 1px solid #1b5e20; padding: 12px 10px; text-align: center; vertical-align: middle; font-size: 13px; font-weight: 600;">#</th>
                            <th width="25%" style="border: 1px solid #1b5e20; padding: 12px 10px; text-align: center; vertical-align: middle; font-size: 13px; font-weight: 600;">Category Name</th>
                            <th width="35%" style="border: 1px solid #1b5e20; padding: 12px 10px; text-align: center; vertical-align: middle; font-size: 13px; font-weight: 600;">Description</th>
                            <th width="15%" style="border: 1px solid #1b5e20; padding: 12px 10px; text-align: center; vertical-align: middle; font-size: 13px; font-weight: 600;">Created At</th>
                            <th width="20%" style="border: 1px solid #1b5e20; padding: 12px 10px; text-align: center; vertical-align: middle; font-size: 13px; font-weight: 600;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        @forelse($categories as $category)
                        <tr id="category-{{ $category->id }}">
                            <td style="border: 1px solid #dee2e6; padding: 10px 12px; text-align: center; vertical-align: middle; font-size: 13px;">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 12px; text-align: center; vertical-align: middle; font-size: 13px;">
                                <strong>{{ $category->name }}</strong>
                            </td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 12px; text-align: center; vertical-align: middle; font-size: 13px;">
                                {{ $category->description ?? 'No description' }}
                            </td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 12px; text-align: center; vertical-align: middle; font-size: 13px;">
                                {{ $category->created_at->format('M d, Y') }}
                            </td>
                            <td style="border: 1px solid #dee2e6; padding: 10px 12px; text-align: center; vertical-align: middle; font-size: 13px;">
                                <div class="actions-col">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-heal-edit btn-edit" 
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}"
                                                data-description="{{ $category->description }}">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-heal-delete btn-delete" 
                                                data-id="{{ $category->id }}" 
                                                data-name="{{ $category->name }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="border: 1px solid #dee2e6; padding: 50px 20px; text-align: center; color: #999;">
                                <i class="fa-solid fa-inbox fa-2x mb-2" style="color: #2e7d32;"></i><br>
                                No categories found. Add your first category!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ============================================================ -->
            <!-- PAGINATION - TULAD NG NASA PICTURE -->
            <!-- ============================================================ -->
            @if($categories->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Showing <strong>{{ $categories->firstItem() ?? 0 }}</strong> to <strong>{{ $categories->lastItem() ?? 0 }}</strong> of <strong>{{ $categories->total() }}</strong> results
                </div>
                <div>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fa-solid fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max(1, $categories->currentPage() - 4);
                            $end = min($categories->lastPage(), $start + 7);
                            $start = max(1, $end - 7);
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @foreach ($categories->getUrlRange($start, $end) as $page => $url)
                            @if ($page == $categories->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        @if($end < $categories->lastPage())
                            @if($end < $categories->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}">{{ $categories->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fa-solid fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif

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
                        <div class="form-text">Category name must be unique. Auto-capitalized.</div>
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

<!-- ============================================================ -->
<!-- SUCCESS MODAL - NO BLUR BACKGROUND -->
<!-- ============================================================ -->
<div id="successModal" class="modal-success-overlay">
    <div class="modal-success-content">
        <div class="success-icon">
            <i class="fa-regular fa-circle-check"></i>
        </div>
        <h3 id="successTitle">Added!</h3>
        <p id="successMessage">Category created successfully!</p>
        <button class="btn-success-modal" id="successModalBtn">OK</button>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ============================================
// SUCCESS MODAL - NO BLUR BACKGROUND
// ============================================
function showSuccessModal(title, message) {
    document.getElementById('successTitle').textContent = title || 'Added!';
    document.getElementById('successMessage').textContent = message || 'Success!';
    document.getElementById('successModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

// Close Success Modal
document.getElementById('successModalBtn').addEventListener('click', function() {
    document.getElementById('successModal').style.display = 'none';
    document.body.style.overflow = '';
});

// Close Success Modal on outside click
document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.style.display = 'none';
        document.body.style.overflow = '';
    }
});

// ============================================
// LIVE SEARCH - REAL TIME (first letter pa lang)
// ============================================
document.getElementById('searchBox').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#categoriesTableBody tr');
    let hasVisibleRows = false;
    
    rows.forEach(row => {
        if (row.cells.length === 1) {
            row.style.display = 'none';
            return;
        }
        
        let textToSearch = '';
        for (let i = 0; i < row.cells.length - 1; i++) {
            textToSearch += row.cells[i].textContent.toLowerCase() + ' ';
        }
        
        const matches = textToSearch.includes(searchTerm);
        row.style.display = matches ? '' : 'none';
        
        if (matches) {
            hasVisibleRows = true;
        }
    });
    
    if (!hasVisibleRows && searchTerm !== '') {
        const noResultRow = document.createElement('tr');
        noResultRow.id = 'noResultRow';
        noResultRow.innerHTML = `
            <td colspan="5" class="text-center text-muted py-4" style="border: 1px solid #dee2e6; padding: 30px;">
                <i class="fa-solid fa-search fa-2x mb-2" style="color: #999;"></i><br>
                No categories found matching "<strong>${this.value}</strong>"
            </td>
        `;
        
        const existingNoResult = document.getElementById('noResultRow');
        if (existingNoResult) existingNoResult.remove();
        
        const visibleRows = document.querySelectorAll('#categoriesTableBody tr:not([style*="display: none"])');
        if (visibleRows.length === 0) {
            document.getElementById('categoriesTableBody').appendChild(noResultRow);
        }
    } else {
        const noResultRow = document.getElementById('noResultRow');
        if (noResultRow) noResultRow.remove();
    }
});

// ============================================
// AUTO CAPITALIZE FIRST LETTER
// ============================================
function capitalizeFirstLetter(input) {
    if (input && input.value && input.value.length > 0) {
        let value = input.value.toLowerCase();
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
    }
}

// ============================================
// REFRESH CATEGORIES TABLE
// ============================================
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
                
                const searchTerm = document.getElementById('searchBox').value;
                if (searchTerm) {
                    document.getElementById('searchBox').dispatchEvent(new Event('input'));
                }
            }
        })
        .catch(error => {
            console.error('Error refreshing table:', error);
            showSuccessModal('Error!', 'Error refreshing table');
        });
}

// ============================================
// ATTACH EVENT LISTENERS
// ============================================
function attachEventListeners() {
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

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete category: "${name}"`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#2e7d32',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#fff',
                iconColor: '#d32f2f'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCategory(id, name);
                }
            });
        });
    });
}

// ============================================
// OPEN ADD MODAL
// ============================================
function openAddModal() {
    document.getElementById('addCategoryForm').reset();
    new bootstrap.Modal(document.getElementById('addCategoryModal')).show();
}

// ============================================
// ADD CATEGORY
// ============================================
document.getElementById('addCategoryBtn').addEventListener('click', openAddModal);

document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
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
            showSuccessModal('Added!', data.message || 'Category created successfully!');
            refreshCategoriesTable();
            document.getElementById('searchBox').value = '';
        } else {
            showSuccessModal('Error!', data.message || 'Error adding category');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showSuccessModal('Error!', 'Error adding category');
    });
});

// ============================================
// EDIT CATEGORY
// ============================================
document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
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
            showSuccessModal('Updated!', data.message || 'Category updated successfully!');
            refreshCategoriesTable();
        } else {
            showSuccessModal('Error!', data.message || 'Error updating category');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showSuccessModal('Error!', 'Error updating category');
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
            showSuccessModal('Deleted!', data.message || `Category "${name}" deleted successfully!`);
            refreshCategoriesTable();
            document.getElementById('searchBox').value = '';
        } else {
            showSuccessModal('Error!', data.message || 'Error deleting category');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showSuccessModal('Error!', 'Error deleting category');
    });
}

// ============================================
// AUTO CAPITALIZE - REAL-TIME
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();
    document.getElementById('searchBox').value = '';
    document.getElementById('searchBox').focus();
    
    const addNameInput = document.getElementById('name');
    if (addNameInput) {
        addNameInput.addEventListener('input', function() { 
            capitalizeFirstLetter(this); 
        });
        addNameInput.addEventListener('blur', function() { 
            capitalizeFirstLetter(this); 
        });
    }
    
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
</script>

@endsection