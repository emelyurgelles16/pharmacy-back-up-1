@if($logs->count() > 0)
<div class="table-responsive">
    <table class="activity-table">
        <thead>
            <tr>
                <th class="col-date">Date & Time</th>
                <th class="col-user">User</th>
                <th class="col-action">Action</th>
                <th class="col-module">Module</th>
                <th class="col-description">Description</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            @php
                $actionKey = strtolower(str_replace('_', '', $log->action ?? 'default'));
                $userInitial = strtoupper(substr($log->user->full_name ?? $log->user->username ?? 'U', 0, 1));
                $avatarColors = ['green', 'blue', 'orange', 'purple', 'red', 'teal'];
                $avatarColor = $avatarColors[$log->id % count($avatarColors)];
            @endphp
            <tr>
                {{-- DATE & TIME --}}
                <td class="col-date">
                    <div class="date-cell">
                        <span class="date">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y') }}</span>
                        <span class="time">{{ \Carbon\Carbon::parse($log->created_at)->format('h:i A') }}</span>
                    </div>
                </td>

                {{-- USER --}}
                <td class="col-user">
                    <div class="user-cell">
                        <div class="user-avatar {{ $avatarColor }}">{{ $userInitial }}</div>
                        <div class="user-info">
                            <div class="user-name" title="{{ $log->user->full_name ?? $log->user->username ?? 'System' }}">
                                {{ $log->user->full_name ?? $log->user->username ?? 'System' }}
                            </div>
                            <div class="user-email" title="{{ $log->user->email ?? 'N/A' }}">
                                {{ $log->user->email ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </td>

                {{-- ACTION --}}
                <td class="col-action">
                    <span class="action-badge" data-action="{{ $actionKey }}">
                        <i class="fas fa-bolt"></i>
                        {{ ucfirst(str_replace('_', ' ', $log->action ?? 'Unknown')) }}
                    </span>
                </td>

                {{-- MODULE --}}
                <td class="col-module">
                    <span class="module-badge" data-module="{{ strtolower($log->module ?? 'default') }}">
                        <i class="fas fa-cube"></i>
                        {{ $log->module ?? 'General' }}
                    </span>
                </td>

                {{-- DESCRIPTION --}}
                <td class="col-description description-cell">
                    <div class="description-box" title="{{ $log->description ?? 'No description' }}">
                        {{ $log->description ?? 'No description' }}
                    </div>
                </td>

                {{-- STATUS --}}
                <td class="col-status">
                    @if(($log->status ?? 'success') == 'Success' || ($log->status ?? 'success') == 'success')
                        <span class="status-badge success">
                            <i class="fas fa-check-circle"></i> Success
                        </span>
                    @else
                        <span class="status-badge failed">
                            <i class="fas fa-times-circle"></i> Failed
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="empty-state">
    <i class="fas fa-inbox empty-icon"></i>
    <p>No Activity Logs Found</p>
    <small>There are no activities to display for the selected filters.</small>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Action colors
        const actionColors = {
            'create': 'action-create', 'add': 'action-add',
            'update': 'action-update', 'edit': 'action-edit',
            'delete': 'action-delete', 'remove': 'action-remove',
            'deduct': 'action-deduct', 'transfer': 'action-transfer',
            'login': 'action-login', 'logout': 'action-logout',
            'view': 'action-view', 'export': 'action-export',
            'print': 'action-print'
        };

        document.querySelectorAll('.action-badge').forEach(function(badge) {
            let actionName = (badge.getAttribute('data-action') || 'default').toLowerCase();
            let className = actionColors[actionName];
            
            if (className) {
                badge.classList.add(className);
            } else {
                let hash = 0;
                for (let i = 0; i < actionName.length; i++) {
                    hash = actionName.charCodeAt(i) + ((hash << 5) - hash);
                }
                let hue = Math.abs(hash) % 360;
                badge.style.setProperty('--hue', hue);
                badge.classList.add('action-dynamic');
            }
        });

        // Module colors
        const moduleColors = {
            'inventory': 'module-inventory', 'pos': 'module-pos',
            'categories': 'module-categories', 'users': 'module-users',
            'profile': 'module-profile', 'settings': 'module-settings',
            'promos': 'module-promos', 'discounts': 'module-discounts',
            'auth': 'module-auth', 'reports': 'module-reports',
            'dashboard': 'module-dashboard'
        };

        document.querySelectorAll('.module-badge').forEach(function(badge) {
            let moduleName = (badge.getAttribute('data-module') || 'default').toLowerCase();
            let className = moduleColors[moduleName];
            
            if (className) {
                badge.classList.add(className);
            } else {
                let hash = 0;
                for (let i = 0; i < moduleName.length; i++) {
                    hash = moduleName.charCodeAt(i) + ((hash << 5) - hash);
                }
                let hue = Math.abs(hash) % 360;
                badge.style.setProperty('--hue', hue);
                badge.classList.add('module-dynamic');
            }
        });
    });
</script>