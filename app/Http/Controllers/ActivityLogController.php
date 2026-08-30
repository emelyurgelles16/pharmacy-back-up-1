<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view logs']);
    }

    public function index(Request $request)
    {
        $users = User::orderBy('full_name')->get();
        $modules = ActivityLog::distinct()->pluck('module')->filter()->values();
        $total = ActivityLog::count();
        $todayCount = ActivityLog::whereDate('created_at', today())->count();
        $uniqueUsers = ActivityLog::distinct('user_id')->count('user_id');
        
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('activity-logs.index', compact('users', 'modules', 'total', 'todayCount', 'uniqueUsers', 'logs'));
    }

    public function getData(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('user') && $request->user != 'all') {
            $query->where('user_id', $request->user);
        }

        if ($request->filled('module') && $request->module != 'all') {
            $query->where('module', $request->module);
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'all':
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('username', 'like', "%{$search}%")
                                ->orWhere('full_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $query->orderBy('created_at', 'desc');
        $logs = $query->paginate(20);

        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'unique_users' => ActivityLog::distinct('user_id')->count('user_id'),
            'modules' => ActivityLog::distinct('module')->count('module'),
        ];

        return response()->json([
            'success' => true,
            'data' => $logs->items(),
            'pagination' => [
                'current_page' => $logs->currentPage(),
                'last_page' => $logs->lastPage(),
                'per_page' => $logs->perPage(),
                'total' => $logs->total(),
                'from' => $logs->firstItem(),
                'to' => $logs->lastItem(),
                'links' => (string) $logs->links(),
            ],
            'stats' => $stats,
            'html' => view('activity-logs.partials.table', ['logs' => $logs])->render(),
        ]);
    }

    public function filter(Request $request)
{
    $user = auth()->user();
    $query = ActivityLog::with('user');
    
    // ✅ Admin can see all logs, others see only their own
    if (!$user->hasRole('Admin')) {
        $query->where('user_id', $user->id);
    }
    
    // ✅ FILTER BY ACTION
    if ($request->filled('action') && $request->action != '') {
        $query->where('action', $request->action);
    }
    
    // ✅ FILTER BY MODULE
    if ($request->filled('module') && $request->module != '') {
        $query->where('module', $request->module);
    }
    
    // ✅ FILTER BY DATE RANGE
    if ($request->filled('start_date') && $request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date') && $request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
    
    // ✅ FILTER BY STATUS
    if ($request->filled('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
    // ✅ FILTER BY USER (if admin and user filter is applied)
    if ($request->filled('user_id') && $request->user_id != '' && $user->hasRole('Admin')) {
        $query->where('user_id', $request->user_id);
    }
    
    $logs = $query->orderBy('created_at', 'desc')->paginate(20);
    
    if ($request->ajax()) {
        return view('activity-logs.partials.table', compact('logs'))->render();
    }
    
    return view('activity-logs.index', compact('logs'));
}

    public function exportPreview()
    {
        $user = auth()->user();
        $query = ActivityLog::orderBy('created_at', 'desc');
        
        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }
        
        $logs = $query->get();
        $totalCount = $logs->count();
        
        $previewData = [];
        foreach ($logs as $log) {
            $previewData[] = [
                'id' => $log->id,
                'user' => $log->user_name,
                'action' => $log->action,
                'module' => $log->module,
                'description' => $log->description,
                'date' => $log->created_at->format('M d, Y h:i A')
            ];
        }
        
        return response()->json([
            'total' => $totalCount,
            'preview' => $previewData
        ]);
    }

    public function export()
    {
        $user = auth()->user();
        $query = ActivityLog::orderBy('created_at', 'desc');
        
        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }
        
        $logs = $query->get();
        
        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        fputcsv($handle, ['ID', 'User', 'Action', 'Module', 'Description', 'IP Address', 'Date/Time']);
        
        foreach ($logs as $log) {
            fputcsv($handle, [
                $log->id,
                $log->user_name,
                $log->action,
                $log->module,
                $log->description,
                $log->ip_address,
                $log->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete logs');
        
        $log = ActivityLog::findOrFail($id);
        $log->delete();
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username ?? 'System',
            'delete',
            'Activity Logs',
            "Deleted log entry #{$log->id}",
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'Log deleted successfully!']);
    }

    public function clearOld(Request $request)
    {
        $this->authorize('delete logs');
        
        $days = $request->days ?? 30;
        $count = ActivityLog::where('created_at', '<', now()->subDays((int)$days))->count();
        ActivityLog::where('created_at', '<', now()->subDays((int)$days))->delete();
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username ?? 'System',
            'clear_old',
            'Activity Logs',
            "Cleared {$count} activity logs older than {$days} days",
            'Success'
        );
        
        return response()->json([
            'success' => true,
            'message' => "Successfully cleared {$count} activity logs older than {$days} days.",
            'deleted' => $count
        ]);
    }

    public function getStats()
    {
        return response()->json([
            'success' => true,
            'stats' => [
                'total' => ActivityLog::count(),
                'today' => ActivityLog::whereDate('created_at', today())->count(),
                'unique_users' => ActivityLog::distinct('user_id')->count('user_id'),
                'modules' => ActivityLog::distinct('module')->count('module'),
            ]
        ]);
    }
}