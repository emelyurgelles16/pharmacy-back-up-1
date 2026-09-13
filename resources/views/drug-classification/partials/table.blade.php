<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 18%;">Name</th>
                <th style="width: 15%;">Type</th>
                <th style="width: 25%;">Description</th>
                <th style="width: 20%;">Requirements</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 9%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classifications as $classification)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $classification->name }}</strong>
                    @if($classification->icon)
                        <span class="ms-1">{{ $classification->icon }}</span>
                    @endif
                </td>
                <td>
                    @php
                        $typeClass = strtolower($classification->type);
                    @endphp
                    <span class="type-badge {{ $typeClass }}">
                        {{ $classification->type }}
                    </span>
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
                <td>
                    <span class="status-badge {{ $classification->is_active ? 'active' : 'inactive' }}">
                        {{ $classification->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="action-btn edit" onclick="editClassification({{ $classification->id }})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn toggle {{ $classification->is_active ? 'active-toggle' : 'inactive-toggle' }}" 
                                onclick="toggleStatus({{ $classification->id }})" 
                                title="{{ $classification->is_active ? 'Deactivate' : 'Activate' }}">
                            <i class="fas {{ $classification->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                        </button>
                        <button class="action-btn delete" onclick="deleteClassification({{ $classification->id }})" title="Delete">
                            <i class="fas fa-trash-alt"></i>
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