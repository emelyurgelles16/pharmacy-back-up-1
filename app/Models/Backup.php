<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = [
        'filename',
        'file_path',
        'backup_type',
        'status',
        'file_size',
        'started_at',
        'completed_at',
        'created_by'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getLastSuccessful()
    {
        return self::where('status', 'success')
            ->orderBy('completed_at', 'desc')
            ->first();
    }

    public static function getNextBackupDate()
    {
        $lastBackup = self::getLastSuccessful();
        $schedule = Setting::get('backup_schedule', 'weekly');
        
        if (!$lastBackup || $schedule === 'disabled') {
            return null;
        }

        $date = $lastBackup->completed_at->copy();
        
        switch ($schedule) {
            case 'daily':
                $date->addDay();
                break;
            case 'weekly':
                $date->addWeek();
                break;
            case 'monthly':
                $date->addMonth();
                break;
            default:
                return null;
        }
        
        return $date;
    }
}