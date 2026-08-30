<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\Setting;
use App\Models\ActivityLog;  // ✅ ADD THIS
use App\Services\BackupService;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    protected $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->middleware(['auth', 'role:Admin']);
        $this->backupService = $backupService;
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'schedule' => 'required|in:daily,weekly,monthly,disabled',
            'retention' => 'required|integer|min:1|max:365'
        ]);

        Setting::set('backup_schedule', $request->schedule);
        Setting::set('backup_retention', $request->retention);
        
        $lastBackup = Backup::getLastSuccessful();
        if ($lastBackup && $request->schedule !== 'disabled') {
            $nextDate = $lastBackup->completed_at->copy();
            switch ($request->schedule) {
                case 'daily':
                    $nextDate->addDay();
                    break;
                case 'weekly':
                    $nextDate->addWeek();
                    break;
                case 'monthly':
                    $nextDate->addMonth();
                    break;
            }
            Setting::set('backup_next_schedule', $nextDate);
        } else {
            Setting::set('backup_next_schedule', null);
        }

        // ✅ FIXED: Use ActivityLog::log() correctly
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username ?? 'System',
            'update',
            'Backup & Recovery',
            "Updated backup settings: Schedule={$request->schedule}, Retention={$request->retention} days",
            'Success'
        );

        return response()->json([
            'success' => true,
            'message' => 'Backup settings saved successfully!'
        ]);
    }

    public function createBackup(Request $request)
    {
        $type = $request->type ?? 'manual';
        $result = $this->backupService->createBackup($type, auth()->id());
        
        return response()->json($result);
    }

    public function getStatus()
    {
        $lastBackup = Backup::getLastSuccessful();
        $nextBackupDate = null;
        
        if ($lastBackup) {
            $schedule = Setting::get('backup_schedule', 'weekly');
            if ($schedule !== 'disabled') {
                $nextBackupDate = $lastBackup->completed_at->copy();
                switch ($schedule) {
                    case 'daily':
                        $nextBackupDate->addDay();
                        break;
                    case 'weekly':
                        $nextBackupDate->addWeek();
                        break;
                    case 'monthly':
                        $nextBackupDate->addMonth();
                        break;
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'schedule' => Setting::get('backup_schedule', 'weekly'),
                'retention' => Setting::get('backup_retention', 30),
                'last_backup' => $lastBackup ? [
                    'date' => $lastBackup->completed_at->format('F d, Y'),
                    'time' => $lastBackup->completed_at->format('h:i A'),
                    'filename' => $lastBackup->filename,
                    'size' => $lastBackup->file_size
                ] : null,
                'next_backup' => $nextBackupDate ? [
                    'date' => $nextBackupDate->format('F d, Y'),
                    'time' => $nextBackupDate->format('h:i A')
                ] : null,
                'has_backup' => $lastBackup !== null
            ]
        ]);
    }
}