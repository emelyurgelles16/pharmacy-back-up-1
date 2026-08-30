@if($logs->count() > 0)
<table>
    <thead>
        <tr>
            <th style="width: 145px;">Date &amp; Time</th>
            <th style="width: 170px;">User</th>
            <th style="width: 110px;">Action</th>
            <th style="width: 130px;">Module</th>
            <th>Description</th>
            <th style="width: 90px; text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>
                <div class="date-cell">
                    <div class="date"><i class="far fa-calendar-alt me-1 text-muted"></i> {{ $log->created_at->format('M d, Y') }}</div>
                    <div class="time"><i class="far fa-clock me-1 text-muted"></i> {{ $log->created_at->format('h:i A') }}</div>
                </div>
            </td>
            <td>
                <div class="user-cell">
                    @php
                        $name = $log->user_name ?? 'Unknown';
                        $initial = strtoupper(substr($name, 0, 1));
                        $colors = ['green', 'blue', 'orange', 'purple', 'red', 'teal'];
                        $color = $colors[($loop->index ?? 0) % count($colors)];
                    @endphp
                    <div class="user-avatar {{ $color }}">{{ $initial }}</div>
                    <div>
                        <div class="user-name">{{ $log->user_name ?? 'Unknown User' }}</div>
                        <div class="user-email">{{ $log->user_email ?? '' }}</div>
                    </div>
                </div>
            </td>
            <td>
                @php
                    $actionClass = 'other';
                    if($log->action == 'create') $actionClass = 'create';
                    elseif($log->action == 'update') $actionClass = 'update';
                    elseif($log->action == 'delete') $actionClass = 'delete';
                    elseif($log->action == 'deduct') $actionClass = 'deduct';
                    elseif($log->action == 'transfer') $actionClass = 'transfer';
                    elseif($log->action == 'login') $actionClass = 'login';
                    elseif($log->action == 'logout') $actionClass = 'logout';

                    $icon = 'fa-circle';
                    if($log->action == 'create') $icon = 'fa-plus';
                    elseif($log->action == 'update') $icon = 'fa-pen';
                    elseif($log->action == 'delete') $icon = 'fa-trash';
                    elseif($log->action == 'deduct') $icon = 'fa-minus-circle';
                    elseif($log->action == 'transfer') $icon = 'fa-exchange-alt';
                    elseif($log->action == 'login') $icon = 'fa-sign-in-alt';
                    elseif($log->action == 'logout') $icon = 'fa-sign-out-alt';
                @endphp
                <span class="action-badge {{ $actionClass }}">
                    <i class="fas {{ $icon }}"></i>
                    {{ ucfirst($log->action ?? 'Unknown') }}
                </span>
            </td>
            <td>
                <span class="module-badge">
                    <i class="fas 
                        @if($log->module == 'Inventory') fa-pills
                        @elseif($log->module == 'POS') fa-cash-register
                        @elseif($log->module == 'Categories') fa-tags
                        @elseif($log->module == 'User & Access') fa-users
                        @elseif($log->module == 'Profile') fa-user
                        @elseif($log->module == 'Settings') fa-sliders-h
                        @elseif($log->module == 'Promos') fa-percentage
                        @elseif($log->module == 'Discount Types') fa-tag
                        @elseif($log->module == 'Auth') fa-shield-alt
                        @else fa-cube
                        @endif me-1"></i>
                    {{ $log->module ?? 'N/A' }}
                </span>
            </td>
            <td>
                <div class="description-cell">
                    {{ Str::limit($log->description ?? $log->activity ?? '', 120) }}
                </div>
            </td>
            <td style="text-align: center;">
                @php
                    $status = $log->status ?? 'Success';
                    $statusClass = strtolower($status) === 'failed' ? 'failed' : 'success';
                @endphp
                <span class="status-badge {{ $statusClass }}">
                    <i class="fas {{ $statusClass == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                    {{ $status }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
    <div class="info">
        Showing <strong>{{ $logs->firstItem() ?? 0 }}</strong> to 
        <strong>{{ $logs->lastItem() ?? 0 }}</strong> of 
        <strong>{{ $logs->total() ?? 0 }}</strong> entries
    </div>
    <div>
        {{ $logs->appends(request()->query())->links() }}
    </div>
</div>

@else
<div class="empty-state">
    <i class="fas fa-history"></i>
    <p>No activity logs found</p>
    <small>Try adjusting your filters to see more results</small>
</div>
@endif