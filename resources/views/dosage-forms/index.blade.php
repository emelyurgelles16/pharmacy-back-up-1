@extends('layouts.app')

@section('title', 'Dosage Forms')

@section('content')
<style>
/* === HEADER === */
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

/* === TOOLBAR === */
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

.toolbar input {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    outline: none;
    height: 40px;
    box-sizing: border-box;
    width: 250px;
}

.toolbar input:focus {
    border-color: #1b5e20;
    box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
}

.toolbar .btn-add {
    background: #1b5e20;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 500;
    white-space: nowrap;
    padding: 10px 22px;
    border-radius: 8px;
    height: 40px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.toolbar .btn-add:hover {
    background: #2e7d32;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(27, 94, 32, 0.3);
}

.toolbar .btn-reset {
    background: #6c757d;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 500;
    white-space: nowrap;
    padding: 10px 18px;
    border-radius: 8px;
    height: 40px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}

.toolbar .btn-reset:hover {
    background: #5a6268;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
}

.search-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-group label {
    margin-right: 0;
}

.search-group input {
    width: 250px;
}

/* === CARD === */
.card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid #eef2f6;
}

.card-header {
    background: linear-gradient(135deg, #1b5e20, #2e7d32) !important;
    color: white !important;
    padding: 12px 20px !important;
    border-bottom: none !important;
}

.card-header h6 {
    margin: 0;
    font-weight: 600;
    font-size: 14px;
}

.card-header h6 i {
    margin-right: 8px;
}

.card-body {
    padding: 0 !important;
}

/* === TABLE === */
.table-responsive {
    overflow-x: auto;
}

.table-mini {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    margin: 0;
}

.table-mini thead th {
    background: #f5f7fa;
    color: #333;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 12px;
    border-bottom: 2px solid #e9ecef;
    text-align: left;
}

.table-mini tbody td {
    padding: 9px 12px;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-mini tbody tr:hover {
    background-color: #f8fdf8;
}

.table-mini tbody tr:last-child td {
    border-bottom: none;
}

/* === BADGES === */
.badge-no {
    background: #e8f5e9;
    color: #1b5e20;
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    min-width: 30px;
    display: inline-block;
    text-align: center;
}

.badge-slug {
    background: #f5f5f5;
    color: #666;
    padding: 2px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-family: monospace;
}

/* === ACTION BUTTONS === */
.action-group {
    display: flex;
    gap: 5px;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-action.btn-edit {
    background: #e3f2fd;
    color: #1565c0;
}

.btn-action.btn-edit:hover {
    background: #1565c0;
    color: white;
}

.btn-action.btn-delete {
    background: #ffebee;
    color: #c62828;
}

.btn-action.btn-delete:hover {
    background: #c62828;
    color: white;
}

/* === PAGINATION === */
.pagination-wrap {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 16px;
    background: #fafafa;
    border-top: 1px solid #eef2f6;
    font-size: 13px;
    color: #666;
}

.pagination-wrap .pagination-links {
    display: flex;
    gap: 4px;
    align-items: center;
}

.pagination-wrap .pagination-links a,
.pagination-wrap .pagination-links span {
    padding: 4px 10px;
    border-radius: 4px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #333;
    font-size: 12px;
    min-width: 30px;
    text-align: center;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.pagination-wrap .pagination-links a:hover {
    background: #1b5e20;
    color: white;
    border-color: #1b5e20;
}

.pagination-wrap .pagination-links .active {
    background: #1b5e20;
    color: white;
    border-color: #1b5e20;
}

.pagination-wrap .pagination-links .disabled {
    color: #ccc;
    border-color: #eee;
    cursor: not-allowed;
}

.pagination-wrap .pagination-links .dots {
    border: none;
    color: #999;
    padding: 4px 6px;
}

/* === EMPTY STATE === */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #999;
}

.empty-state i {
    font-size: 40px;
    opacity: 0.3;
    margin-bottom: 10px;
}

.empty-state small {
    color: #aaa;
}

/* === NOTIFICATION === */
#notification {
    position: fixed;
    top: 18px;
    right: 18px;
    padding: 12px 18px;
    border-radius: 10px;
    color: #fff;
    display: none;
    z-index: 2000;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    font-weight: 600;
    font-size: 13px;
}

/* === MODAL - EDIT === */
.modal-content-edit {
    border-radius: 12px;
    border: none;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
}

.modal-content-edit .modal-header {
    background: linear-gradient(135deg, #1b5e20, #2e7d32);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 14px 20px;
    border-bottom: none;
}

.modal-content-edit .modal-header h6 {
    font-size: 16px;
    font-weight: 700;
    margin: 0;
}

.modal-content-edit .modal-header small {
    font-size: 12px;
    opacity: 0.85;
}

.modal-content-edit .modal-body {
    padding: 18px 22px;
}

.modal-content-edit .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 12px 22px;
    background: #fafafa;
    border-radius: 0 0 12px 12px;
}

.modal-content-edit .form-label {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.modal-content-edit .form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 10px 14px;
    font-size: 14px;
    width: 100%;
}

.modal-content-edit .form-control:focus {
    border-color: #1b5e20;
    box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.15);
    outline: none;
}

.modal-content-edit .form-control.textarea-edit {
    resize: vertical;
    min-height: 60px;
}

.modal-content-edit .text-muted-sm {
    font-size: 12px;
    color: #999;
    display: block;
    margin-top: 4px;
}

.modal-content-edit .btn-cancel-edit {
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    background: #6c757d;
    color: white;
    border: none;
}

.modal-content-edit .btn-cancel-edit:hover {
    background: #5a6268;
}

.modal-content-edit .btn-update-edit {
    border-radius: 6px;
    padding: 8px 20px;
    font-size: 13px;
    font-weight: 500;
    background: linear-gradient(135deg, #1b5e20, #2e7d32);
    color: white;
    border: none;
}

.modal-content-edit .btn-update-edit:hover {
    background: linear-gradient(135deg, #2e7d32, #388e3c);
}

/* === MODAL - ADD === */
.modal-content-add {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-content-add .modal-header {
    background: #1b5e20;
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 15px 20px;
    border-bottom: none;
}

.modal-content-add .modal-header h5 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
}

.modal-content-add .modal-body {
    padding: 20px 25px;
}

.modal-content-add .modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 12px 25px;
    background: #fafafa;
    border-radius: 0 0 12px 12px;
}

.modal-content-add .form-label-add {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
}

.modal-content-add .form-control-add {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 10px 14px;
    font-size: 14px;
    width: 100%;
}

.modal-content-add .form-control-add:focus {
    border-color: #1b5e20;
    box-shadow: 0 0 0 3px rgba(27, 94, 32, 0.1);
    outline: none;
}

.modal-content-add .form-control-add.textarea-add {
    resize: vertical;
    min-height: 60px;
}

.modal-content-add .btn-cancel-add {
    border-radius: 6px;
    padding: 8px 22px;
    font-size: 14px;
    font-weight: 500;
    background: #6c757d;
    color: white;
    border: none;
}

.modal-content-add .btn-cancel-add:hover {
    background: #5a6268;
}

.modal-content-add .btn-save-add {
    border-radius: 6px;
    padding: 8px 22px;
    font-size: 14px;
    font-weight: 500;
    background: #1b5e20;
    color: white;
    border: none;
}

.modal-content-add .btn-save-add:hover {
    background: #2e7d32;
}

/* === RESPONSIVE === */
@media (max-width: 768px) {
    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    .toolbar input {
        width: 100%;
    }
    .search-group {
        flex-wrap: wrap;
    }
    .pagination-wrap {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
    .table-mini {
        font-size: 12px;
    }
    .table-mini thead th,
    .table-mini tbody td {
        padding: 6px 8px;
    }
}
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="header-box">
        <h2><i class="fa-solid fa-pills"></i> Dosage Forms</h2>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="search-group">
                <label>Search:</label>
                <input type="text" id="searchBox" placeholder="Search dosage forms..." value="{{ request('search') }}">
                <button id="resetBtn" class="btn-reset">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </button>
            </div>
        </div>
        <div class="toolbar-right">
            <button id="addBtn" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add New
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h6><i class="fa-solid fa-list"></i> All Dosage Forms</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-mini" id="dosageFormsTable">
                    <thead>
                        <tr>
                            <th style="width:50px;">No.</th>
                            <th>Form Name</th>
                            <th style="width:120px;">Slug</th>
                            <th style="width:80px;">Unit</th>
                            <th>Description</th>
                            <th style="width:150px;">Date Created</th>
                            <th style="width:90px; text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($dosageForms as $index => $form)
                        <tr id="row-{{ $form->id }}">
                            <td><span class="badge-no">{{ $loop->iteration }}</span></td>
                            <td><strong>{{ $form->name }}</strong></td>
                            <td><span class="badge-slug">{{ $form->slug }}</span></td>
                            <td><span class="badge-slug">{{ $form->abbreviation ?? '—' }}</span></td>
                            <td>{{ $form->description ?? '—' }}</td>
                            <td style="font-size:12px; color:#888;">{{ $form->created_at ? $form->created_at->format('M d, Y h:i A') : '—' }}</td>
                            <td style="text-align:center;">
                                <div class="action-group">
                                    <button class="btn-action btn-edit" 
                                            data-id="{{ $form->id }}"
                                            data-name="{{ $form->name }}"
                                            data-unit="{{ $form->abbreviation ?? '' }}"
                                            data-description="{{ $form->description ?? '' }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <button class="btn-action btn-delete" 
                                            data-id="{{ $form->id }}" 
                                            data-name="{{ $form->name }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-inbox"></i>
                                    <div>No dosage forms found.</div>
                                    <small>Click "Add New" to create one.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($dosageForms->hasPages())
            <div class="pagination-wrap">
                <span>
                    Showing {{ $dosageForms->firstItem() }} to {{ $dosageForms->lastItem() }} of {{ $dosageForms->total() }} results
                </span>
                <div class="pagination-links">
                    {{-- Previous --}}
                    @if($dosageForms->onFirstPage())
                        <span class="disabled">‹</span>
                    @else
                        <a href="{{ $dosageForms->previousPageUrl() }}">‹</a>
                    @endif

                    {{-- Page numbers --}}
                    @php
                        $currentPage = $dosageForms->currentPage();
                        $lastPage = $dosageForms->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $dosageForms->url(1) }}">1</a>
                        @if($start > 2)
                            <span class="dots">…</span>
                        @endif
                    @endif

                    @for($i = $start; $i <= $end; $i++)
                        @if($i == $currentPage)
                            <span class="active">{{ $i }}</span>
                        @else
                            <a href="{{ $dosageForms->url($i) }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span class="dots">…</span>
                        @endif
                        <a href="{{ $dosageForms->url($lastPage) }}">{{ $lastPage }}</a>
                    @endif

                    {{-- Next --}}
                    @if($dosageForms->hasMorePages())
                        <a href="{{ $dosageForms->nextPageUrl() }}">›</a>
                    @else
                        <span class="disabled">›</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ========== ADD MODAL ========== -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content modal-content-add">
            <div class="modal-header">
                <h5><i class="fa-solid fa-plus me-2"></i> Add Dosage Form</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="addForm">
                @csrf
                <div class="modal-body">
                    <div id="addAlert" style="display: none; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; font-weight: 500; background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;">
                        <span id="addAlertText"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-add">Form Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control-add" id="add_name" name="name" required 
                               placeholder="Enter dosage form name...">
                        <small class="text-muted" style="font-size: 12px; display: block; margin-top: 5px;">
                            <i class="fa-solid fa-info-circle me-1"></i> This will appear in inventory as "Form"
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-add">Unit <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control-add" id="add_unit" name="abbreviation" 
                               placeholder="e.g., mg, ml, g, tablet, capsule...">
                        <small class="text-muted" style="font-size: 12px; display: block; margin-top: 5px;">
                            <i class="fa-solid fa-info-circle me-1"></i> Abbreviation or unit of measurement
                        </small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-add">Description <span class="text-muted">(Optional)</span></label>
                        <textarea class="form-control-add textarea-add" id="add_desc" name="description" rows="2" 
                                  placeholder="Enter a short description..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel-add" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save-add">
                        <i class="fa-solid fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========== EDIT MODAL ========== -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content modal-content-edit">
            <div class="modal-header">
                <div>
                    <h6><i class="fa-solid fa-pencil me-2"></i> Edit Dosage Form</h6>
                    <small>Update the dosage form information</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="modal-body">
                    <div id="editAlert" style="display: none; padding: 10px 14px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; font-weight: 500; background: #ffebee; color: #c62828; border: 1px solid #ef9a9a;">
                        <span id="editAlertText"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Form Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <small class="text-muted-sm">
                            <i class="fa-solid fa-info-circle me-1"></i> This will appear in inventory as "Form"
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Unit <span class="text-muted">(Optional)</span></label>
                        <input type="text" class="form-control" id="edit_unit" name="abbreviation" 
                               placeholder="e.g., mg, ml, g, tablet, capsule...">
                        <small class="text-muted-sm">
                            <i class="fa-solid fa-info-circle me-1"></i> Abbreviation or unit of measurement
                        </small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Description <span class="text-muted">(Optional)</span></label>
                        <textarea class="form-control textarea-edit" id="edit_desc" name="description" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel-edit" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-update-edit">
                        <i class="fa-solid fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification"></div>

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

// ============================================
// SEARCH
// ============================================
function applySearch() {
    const search = document.getElementById('searchBox').value;
    let url = '{{ route("dosage-forms.index") }}?';
    if (search) url += 'search=' + encodeURIComponent(search);
    window.location.href = url;
}

document.getElementById('searchBox').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') applySearch();
});

// ============================================
// RESET BUTTON
// ============================================
document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('searchBox').value = '';
    window.location.href = '{{ route("dosage-forms.index") }}';
    showNotif('🔄 Search has been reset!', 'success');
});

// ============================================
// NOTIFICATION
// ============================================
function showNotif(msg, type = 'success') {
    const el = document.getElementById('notification');
    const colors = { success: '#1b5e20', created: '#1b5e20', updated: '#f57c00', deleted: '#c62828', error: '#c62828' };
    el.style.background = colors[type] || '#1b5e20';
    el.innerHTML = msg;
    el.style.display = 'block';
    el.style.opacity = 1;
    setTimeout(() => { el.style.opacity = 0; setTimeout(() => el.style.display = 'none', 300); }, 2000);
}

// ============================================
// REFRESH TABLE
// ============================================
function refreshTable() {
    applySearch();
}

// ============================================
// ATTACH EVENTS
// ============================================
function attachEvents() {
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const unit = this.dataset.unit || '';
            const description = this.dataset.description || '';
            
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_unit').value = unit;
            document.getElementById('edit_desc').value = description;
            
            document.getElementById('editAlert').style.display = 'none';
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            Swal.fire({
                title: 'Delete Form?',
                html: `Are you sure you want to delete <strong>"${name}"</strong>?<br><small style="color:#999;">This action cannot be undone.</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#c62828',
                cancelButtonColor: '#1b5e20',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                    
                    fetch(`/dosage-forms/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: `"${name}" has been removed.`,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            refreshTable();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Cannot delete this item.'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.'
                        });
                    });
                }
            });
        });
    });
}

// ============================================
// ADD
// ============================================
document.getElementById('addBtn').addEventListener('click', () => {
    document.getElementById('addForm').reset();
    document.getElementById('addAlert').style.display = 'none';
    new bootstrap.Modal(document.getElementById('addModal')).show();
});

document.getElementById('addForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    capitalizeFirstLetter(document.getElementById('add_name'));
    
    const fd = new FormData(this);
    const alertDiv = document.getElementById('addAlert');
    const alertText = document.getElementById('addAlertText');
    
    alertDiv.style.display = 'none';
    
    Swal.fire({
        title: 'Saving...',
        text: 'Please wait.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch('{{ route("dosage-forms.store") }}', {
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
            'Accept': 'application/json' 
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        Swal.close();
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: data.message || 'Dosage form added successfully.',
                timer: 1500,
                showConfirmButton: false
            });
            refreshTable();
        } else {
            alertDiv.style.display = 'block';
            alertText.textContent = data.message || 'Failed to add. Please try again.';
            setTimeout(() => { alertDiv.style.display = 'none'; }, 5000);
        }
    })
    .catch((error) => {
        Swal.close();
        console.error('Add error:', error);
        alertDiv.style.display = 'block';
        alertText.textContent = 'Something went wrong. Please try again.';
        setTimeout(() => { alertDiv.style.display = 'none'; }, 5000);
    });
});

// ============================================
// EDIT
// ============================================
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    capitalizeFirstLetter(document.getElementById('edit_name'));
    
    const id = document.getElementById('edit_id').value;
    const fd = new FormData(this);
    const alertDiv = document.getElementById('editAlert');
    const alertText = document.getElementById('editAlertText');
    
    alertDiv.style.display = 'none';
    
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch(`/dosage-forms/${id}`, {
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}', 
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'PUT'
        },
        body: fd
    })
    .then(res => res.json())
    .then(data => {
        Swal.close();
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message || 'Dosage form updated successfully.',
                timer: 1500,
                showConfirmButton: false
            });
            refreshTable();
        } else {
            alertDiv.style.display = 'block';
            alertText.textContent = data.message || 'Failed to update. Please try again.';
            setTimeout(() => { alertDiv.style.display = 'none'; }, 5000);
        }
    })
    .catch((error) => {
        Swal.close();
        console.error('Edit error:', error);
        alertDiv.style.display = 'block';
        alertText.textContent = 'Something went wrong. Please try again.';
        setTimeout(() => { alertDiv.style.display = 'none'; }, 5000);
    });
});

// ============================================
// AUTO CAPITALIZE - REAL-TIME
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    attachEvents();
    
    ['add_name', 'edit_name'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() { capitalizeFirstLetter(this); });
            input.addEventListener('blur', function() { capitalizeFirstLetter(this); });
        }
    });
});
</script>
@endsection