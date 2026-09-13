@extends('layouts.app')

@section('title', 'Drug Classification')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - DRUG CLASSIFICATION
       ============================================ */

    /* ===== HEADER BOX ===== */
    .header-box {
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 12px;
        padding: 20px 30px;
        margin-bottom: 30px;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

    /* ===== TOOLBAR ===== */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
        background: white;
        padding: 12px 18px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .toolbar .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 4px 12px 4px 4px;
        border-radius: 8px;
        border: 1px solid #e8e8e8;
    }

    .toolbar .search-box input {
        border: none;
        background: transparent;
        padding: 6px 10px;
        height: 34px;
        width: 220px;
        outline: none;
        font-size: 13px;
    }

    .toolbar .search-box input::placeholder {
        color: #aaa;
    }

    .toolbar .btn-add {
        background: #0b7a33;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .toolbar .btn-add:hover {
        background: #056b28;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.3);
    }

    /* ============================================================ */
    /* TABLE WITH BORDER LINES */
    /* ============================================================ */
    .table-wrapper {
        background: white;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        border: 1px solid #dee2e6;
    }

    .table-wrapper thead th {
        background: #0b7a33;
        color: white;
        padding: 12px 10px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border: 1px solid #0b7a33;
        text-align: center;
        vertical-align: middle;
        letter-spacing: 0.5px;
    }

    .table-wrapper tbody td {
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
        font-size: 13px;
        text-align: center;
    }

    .table-wrapper tbody tr:hover {
        background-color: rgba(46, 125, 50, 0.08);
        transition: all 0.2s ease;
    }

    .table-wrapper tbody tr:nth-child(even) {
        background-color: #fafffa;
    }

    /* ===== STATUS BADGE ===== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-badge.active { background: #e8f5e9; color: #2e7d32; }
    .status-badge.inactive { background: #fce4ec; color: #c62828; }

    /* ===== REQUIREMENT BADGES ===== */
    .req-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        margin: 1px 2px;
    }
    .req-badge.prescription { background: #fff3e0; color: #e65100; }
    .req-badge.special { background: #ffebee; color: #c62828; }
    .req-badge.logging { background: #e3f2fd; color: #1565c0; }

    /* ============================================================ */
    /* ACTION BUTTONS */
    /* ============================================================ */
    .btn-heal-edit {
        background-color: #ff9800;
        border-color: #ff9800;
        color: white;
    }

    .btn-heal-edit:hover {
        background-color: #f57c00;
        border-color: #f57c00;
        color: white;
    }

    .btn-heal-delete {
        background-color: #d32f2f;
        border-color: #d32f2f;
        color: white;
    }

    .btn-heal-delete:hover {
        background-color: #c62828;
        border-color: #c62828;
        color: white;
    }

    .btn-group .btn {
        margin-right: 5px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 12px;
        padding: 6px 14px;
    }

    .actions-col {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    /* ============================================================ */
    /* PAGINATION - TULAD NG NASA PICTURE */
    /* ============================================================ */
    .pagination-wrapper {
        padding: 15px 18px;
        background: #fafbfc;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-wrapper .pagination-info {
        font-size: 13px;
        color: #6c757d;
        white-space: nowrap;
    }
    .pagination-wrapper .pagination-info strong {
        color: #1a1a2e;
    }

    .pagination {
        display: flex;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        display: inline-block;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        background: white;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .pagination .page-link:hover {
        background: #e8f5e9;
        border-color: #0b7a33;
        color: #0b7a33;
    }

    .pagination .page-item.active .page-link {
        background: #0b7a33;
        border-color: #0b7a33;
        color: white;
        font-weight: 700;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination .page-link i {
        font-size: 11px;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #adb5bd;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.3;
    }
    .empty-state p {
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 4px;
    }
    .empty-state small {
        font-size: 13px;
        color: #adb5bd;
    }

    /* ============================================
       🎯 MODAL / OVERLAY STYLES
       ============================================ */

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-container {
        background: white;
        border-radius: 12px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        padding: 14px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }

    .modal-header-custom h5 {
        color: white;
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .modal-header-custom h5 i {
        margin-right: 10px;
    }

    .modal-close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0 4px;
    }

    .modal-close-btn:hover {
        transform: rotate(90deg);
    }

    .modal-body-custom {
        padding: 20px 25px;
        max-height: calc(90vh - 80px);
        overflow-y: auto;
    }

    .modal-body-custom::-webkit-scrollbar {
        width: 4px;
    }
    .modal-body-custom::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .modal-body-custom::-webkit-scrollbar-thumb {
        background: #0b7a33;
        border-radius: 4px;
    }

    .modal-footer-custom {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 12px 25px 20px;
        border-top: 1px solid #e8e8e8;
    }

    /* ===== MODAL FORM ELEMENTS ===== */
    .modal-body-custom .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #333;
        margin-bottom: 3px;
        display: block;
    }

    .modal-body-custom .form-label .required {
        color: #dc3545;
    }

    .modal-body-custom .form-control,
    .modal-body-custom .form-select {
        width: 100%;
        padding: 7px 12px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        font-size: 13px;
        transition: all 0.3s;
    }

    .modal-body-custom .form-control:focus,
    .modal-body-custom .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .modal-body-custom .form-hint {
        font-size: 12px;
        color: #999;
        margin-top: 3px;
    }

    .modal-body-custom .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 0;
    }

    .modal-body-custom .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #0b7a33;
        cursor: pointer;
    }

    .modal-body-custom .checkbox-group label {
        font-size: 13px;
        cursor: pointer;
        margin: 0;
    }

    .btn-submit-modal {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 8px 24px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-submit-modal:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(11, 122, 51, 0.3);
    }

    .btn-submit-modal:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel-modal {
        background: #f5f5f5;
        color: #666;
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel-modal:hover {
        background: #e8e8e8;
        color: #333;
    }

    /* ===== NOTIFICATION ===== */
    #notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 10px;
        color: #fff;
        display: none;
        z-index: 10000;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        font-weight: 600;
        font-size: 13px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-box {
            padding: 16px 20px;
        }
        .header-box h2 {
            font-size: 20px;
        }
        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .toolbar .search-box input {
            width: 100%;
        }
        .modal-container {
            max-width: 100%;
            margin: 10px;
        }
        .modal-body-custom {
            padding: 15px;
        }
        .modal-footer-custom {
            flex-direction: column;
        }
        .modal-footer-custom button,
        .modal-footer-custom a {
            width: 100%;
            justify-content: center;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        .pagination-wrapper {
            flex-direction: column;
            align-items: center;
        }
        .pagination .page-link {
            min-width: 28px;
            height: 28px;
            font-size: 12px;
            padding: 0 8px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .table-wrapper thead th,
        .table-wrapper tbody td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .modal-header-custom h5 {
            font-size: 16px;
        }
    }
</style>

<div class="container-fluid px-3">

    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-capsules"></i>
            Drug Classification
        </h2>
    </div>

    <!-- ===== TOOLBAR ===== -->
    <div class="toolbar">
        <div class="search-box">
            <i class="fas fa-search text-muted"></i>
            <input type="text" id="searchBox" placeholder="Search classification name...">
        </div>
        <div>
            <button id="addBtn" class="btn-add">
                <i class="fas fa-plus-circle"></i> Add New Classification
            </button>
        </div>
    </div>

    <!-- ===== TABLE WITH BORDER LINES ===== -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 18%;">Name</th>
                    <th style="width: 25%;">Description</th>
                    <th style="width: 20%;">Requirements</th>
                    <th style="width: 12%;">Created</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 12%;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($classifications as $classification)
                <tr>
                    <td>{{ $classifications->firstItem() + $loop->index }}</td>
                    <td>
                        <strong>{{ $classification->name }}</strong>
                        @if($classification->icon)
                            <span class="ms-1">{{ $classification->icon }}</span>
                        @endif
                    </td>
                    <td>{{ Str::limit($classification->description ?? 'No description', 60) }}</td>
                    <td>
                        @if($classification->requires_prescription)
                            <span class="req-badge prescription"><i class="fas fa-prescription"></i> Rx</span>
                        @endif
                        @if($classification->requires_special_handling)
                            <span class="req-badge special"><i class="fas fa-exclamation-triangle"></i> Special</span>
                        @endif
                        @if($classification->requires_logging)
                            <span class="req-badge logging"><i class="fas fa-clipboard-list"></i> Log</span>
                        @endif
                        @if(!$classification->requires_prescription && !$classification->requires_special_handling && !$classification->requires_logging)
                            <span class="text-muted" style="font-size: 11px;">None</span>
                        @endif
                    </td>
                    <td>{{ $classification->created_at ? $classification->created_at->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <span class="status-badge {{ $classification->is_active ? 'active' : 'inactive' }}">
                            {{ $classification->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="actions-col">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-heal-edit" onclick="editClassification({{ $classification->id }})" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-heal-delete" onclick="deleteClassification({{ $classification->id }})" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-capsules"></i>
                            <p>No drug classifications found</p>
                            <small>Click "Add New Classification" to create one.</small>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ===== PAGINATION - TULAD NG NASA PICTURE ===== -->
    @if($classifications->total() > 0)
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Showing <strong>{{ $classifications->firstItem() ?? 0 }}</strong> to <strong>{{ $classifications->lastItem() ?? 0 }}</strong> of <strong>{{ $classifications->total() }}</strong> results
        </div>
        <div>
            {{ $classifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif

</div>

<!-- ============================================ -->
<!-- ADD/EDIT CLASSIFICATION MODAL (OVERLAY) -->
<!-- ============================================ -->
<div id="classificationModal" class="modal-overlay">
    <div class="modal-container">
        <!-- Modal Header -->
        <div class="modal-header-custom">
            <h5 id="modalTitle"><i class="fas fa-plus-circle"></i> Add New Classification</h5>
            <button type="button" class="modal-close-btn" id="closeModalBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body-custom">
            <form id="classificationForm" method="POST">
                @csrf
                <input type="hidden" id="edit_id" name="id">

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Classification Name <span class="required">*</span></label>
                    <input type="text" name="name" id="modalName" class="form-control" placeholder="e.g., Over-the-Counter (OTC)" required>
                    <div class="form-hint" id="nameError" style="display: none; color: #dc3545;"></div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="modalDescription" class="form-control" rows="3" placeholder="Describe this classification..."></textarea>
                </div>

                <!-- Requirements -->
                <div class="mb-3">
                    <label class="form-label">Requirements</label>
                    <div class="checkbox-group">
                        <input type="checkbox" name="requires_prescription" id="modalRequiresPrescription" value="1">
                        <label for="modalRequiresPrescription">📋 Requires Prescription</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="requires_special_handling" id="modalRequiresSpecialHandling" value="1">
                        <label for="modalRequiresSpecialHandling">⚠️ Requires Special Handling</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" name="requires_logging" id="modalRequiresLogging" value="1">
                        <label for="modalRequiresLogging">📝 Requires Logging</label>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <div class="checkbox-group">
                        <input type="checkbox" name="is_active" id="modalIsActive" value="1" checked>
                        <label for="modalIsActive">✅ Active</label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="modal-footer-custom">
                    <button type="button" class="btn-cancel-modal" id="cancelModalBtn">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-submit-modal" id="submitModalBtn">
                        <i class="fas fa-save me-1"></i> Save Classification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION ===== -->
<div id="notification"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let isSubmitting = false;
    let isEditMode = false;

    // ============================================
    // SEARCH
    // ============================================
    $('#searchBox').on('keyup', function() {
        let search = $(this).val().toLowerCase().trim();
        $('#tableBody tr').each(function() {
            let text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(search) > -1);
        });
    });

    // ============================================
    // MODAL FUNCTIONS
    // ============================================
    function openModal(title = 'Add New Classification', data = null) {
        $('#modalTitle').html('<i class="fas fa-' + (data ? 'edit' : 'plus-circle') + '"></i> ' + title);
        
        if (data) {
            isEditMode = true;
            $('#edit_id').val(data.id);
            $('#modalName').val(data.name);
            $('#modalDescription').val(data.description || '');
            $('#modalRequiresPrescription').prop('checked', data.requires_prescription === 1 || data.requires_prescription === true);
            $('#modalRequiresSpecialHandling').prop('checked', data.requires_special_handling === 1 || data.requires_special_handling === true);
            $('#modalRequiresLogging').prop('checked', data.requires_logging === 1 || data.requires_logging === true);
            $('#modalIsActive').prop('checked', data.is_active === 1 || data.is_active === true);
            $('#submitModalBtn').html('<i class="fas fa-save me-1"></i> Update Classification');
        } else {
            isEditMode = false;
            $('#edit_id').val('');
            $('#classificationForm')[0].reset();
            $('#modalIsActive').prop('checked', true);
            $('#submitModalBtn').html('<i class="fas fa-save me-1"></i> Save Classification');
        }
        
        $('#nameError').hide();
        $('#classificationModal').addClass('active');
        $('body').css('overflow', 'hidden');
        setTimeout(() => $('#modalName').focus(), 200);
    }

    function closeModal() {
        $('#classificationModal').removeClass('active');
        $('body').css('overflow', 'auto');
    }

    // ============================================
    // OPEN ADD MODAL
    // ============================================
    $('#addBtn').on('click', function() {
        openModal('Add New Classification');
    });

    // ============================================
    // OPEN EDIT MODAL - COMPLETE WITH AJAX
    // ============================================
    window.editClassification = function(id) {
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: '/drug-classification/' + id + '/edit',
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                Swal.close();
                if (response.success && response.classification) {
                    openModal('Edit Classification', response.classification);
                } else {
                    showNotification('Failed to load classification data', 'error');
                }
            },
            error: function(xhr) {
                Swal.close();
                console.error('AJAX Error:', xhr);
                showNotification('Failed to load classification data', 'error');
            }
        });
    };

    // ============================================
    // CLOSE MODAL
    // ============================================
    $('#closeModalBtn, #cancelModalBtn').on('click', closeModal);

    $('#classificationModal').on('click', function(e) {
        if ($(e.target).is(this)) {
            closeModal();
        }
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#classificationModal').hasClass('active')) {
            closeModal();
        }
    });

    // ============================================
    // RELOAD TABLE - AJAX (NO PAGE RELOAD)
    // ============================================
    function reloadTable() {
        $.ajax({
            url: window.location.href,
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                var html = $(response).find('#tableBody').html();
                if (html) {
                    $('#tableBody').html(html);
                    var paginationInfo = $(response).find('.pagination-info').html();
                    if (paginationInfo) {
                        $('.pagination-info').html(paginationInfo);
                    }
                    var paginationLinks = $(response).find('.pagination').html();
                    if (paginationLinks) {
                        $('.pagination').html(paginationLinks);
                    }
                } else {
                    location.reload();
                }
            },
            error: function() {
                location.reload();
            }
        });
    }

    // ============================================
    // FORM SUBMIT WITH AJAX - COMPLETE FIXED
    // ============================================
    $('#classificationForm').on('submit', function(e) {
        e.preventDefault();

        if (isSubmitting) {
            return false;
        }

        let name = $('#modalName').val().trim();
        let description = $('#modalDescription').val().trim();

        if (!name) {
            $('#nameError').text('Classification name is required.').show();
            $('#modalName').focus();
            return false;
        }
        $('#nameError').hide();

        isSubmitting = true;
        const submitBtn = $('#submitModalBtn');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

        let id = $('#edit_id').val();
        let url = id ? '/drug-classification/' + id : '/drug-classification';
        
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', name);
        formData.append('description', description);
        formData.append('requires_prescription', $('#modalRequiresPrescription').is(':checked') ? '1' : '0');
        formData.append('requires_special_handling', $('#modalRequiresSpecialHandling').is(':checked') ? '1' : '0');
        formData.append('requires_logging', $('#modalRequiresLogging').is(':checked') ? '1' : '0');
        formData.append('is_active', $('#modalIsActive').is(':checked') ? '1' : '0');
        
        if (id) {
            formData.append('_method', 'PUT');
        }

        console.log('📤 Sending data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(response) {
                console.log('✅ Response:', response);
                if (response.success) {
                    closeModal();
                    showNotification(response.message || (id ? 'Classification updated successfully!' : 'Classification created successfully!'), 'success');
                    reloadTable();
                    isSubmitting = false;
                    submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> ' + (id ? 'Update Classification' : 'Save Classification'));
                } else {
                    showNotification(response.message || 'Failed to save classification', 'error');
                    isSubmitting = false;
                    submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> ' + (id ? 'Update Classification' : 'Save Classification'));
                }
            },
            error: function(xhr) {
                console.error('❌ AJAX Error:', xhr);
                console.error('❌ Response Text:', xhr.responseText);
                let errorMsg = 'Something went wrong. Please try again.';
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#nameError').text(errors.name[0]).show();
                        $('#modalName').focus();
                        errorMsg = errors.name[0];
                    } else {
                        errorMsg = Object.values(errors).flat()[0] || errorMsg;
                    }
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification(errorMsg, 'error');
                isSubmitting = false;
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> ' + (id ? 'Update Classification' : 'Save Classification'));
            }
        });
    });

    // ============================================
    // DELETE - WITH AJAX
    // ============================================
    window.deleteClassification = function(id) {
        let name = $(`button[onclick="deleteClassification(${id})"]`).closest('tr').find('td:eq(1) strong').text() || 'this classification';

        Swal.fire({
            title: 'Delete Classification?',
            html: `Are you sure you want to delete <strong>${name}</strong>?<br><small style="color:#999;">This action cannot be undone.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: '/drug-classification/' + id,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'Classification deleted successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                reloadTable();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to delete classification.',
                                confirmButtonColor: '#d32f2f'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to delete classification. Please try again.',
                            confirmButtonColor: '#d32f2f'
                        });
                    }
                });
            }
        });
    };

    // ============================================
    // NOTIFICATION
    // ============================================
    function showNotification(msg, type = 'success') {
        const el = document.getElementById('notification');
        const colors = {
            success: '#0b7a33',
            error: '#dc3545',
            warning: '#ff9800',
            info: '#17a2b8'
        };
        
        el.style.background = colors[type] || colors.success;
        el.innerHTML = '<i class="fas fa-' + (type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle') + ' me-2"></i> ' + msg;
        el.style.display = 'block';
        el.style.opacity = 1;
        
        setTimeout(() => {
            el.style.opacity = 0;
            setTimeout(() => el.style.display = 'none', 300);
        }, 3000);
    }

    console.log('✅ Drug Classification page loaded successfully!');
});
</script>

@endsection