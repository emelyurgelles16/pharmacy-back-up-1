<?php

namespace App\Services;

use App\Models\Backup;
use App\Models\Setting;
use App\Models\ActivityLog;  // ✅ CORRECT NAMESPACE
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupService
{
    protected $backupPath;
    
    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    public function createBackup($type = 'manual', $userId = null)
    {
        $backup = Backup::create([
            'filename' => '',
            'file_path' => '',
            'backup_type' => $type,
            'status' => 'pending',
            'started_at' => now(),
            'created_by' => $userId
        ]);

        try {
            $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.zip';
            $filePath = $this->backupPath . '/' . $filename;
            
            $sqlFile = $this->createDatabaseDump();
            
            // ✅ Check if ZipArchive exists
            if (!class_exists('ZipArchive')) {
                throw new \Exception('ZipArchive extension is not enabled. Please enable it in php.ini');
            }
            
            $this->createZipFile($filePath, $sqlFile);
            
            if (File::exists($sqlFile)) {
                File::delete($sqlFile);
            }
            
            $backup->update([
                'filename' => $filename,
                'file_path' => 'backups/' . $filename,
                'file_size' => File::exists($filePath) ? $this->formatSize(File::size($filePath)) : null,
                'status' => 'success',
                'completed_at' => now()
            ]);
            
            Setting::set('backup_last_success', now());
            $this->updateNextBackup();
            $this->cleanOldBackups();
            
            // ✅ FIXED: ActivityLog namespace
            $username = $userId ? \App\Models\User::find($userId)?->username ?? 'System' : 'System';
            ActivityLog::log(
                $userId,
                $username,
                'backup',
                'Backup & Recovery',
                "Created {$type} database backup: {$filename}",
                'Success'
            );
            
            return [
                'success' => true,
                'backup' => $backup,
                'message' => 'Backup created successfully!'
            ];
            
        } catch (\Exception $e) {
            $backup->update([
                'status' => 'failed',
                'completed_at' => now()
            ]);
            
            $username = $userId ? \App\Models\User::find($userId)?->username ?? 'System' : 'System';
            ActivityLog::log(
                $userId,
                $username,
                'backup_failed',
                'Backup & Recovery',
                "Failed to create backup: " . $e->getMessage(),
                'Failed'
            );
            
            return [
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ];
        }
    }

    protected function createDatabaseDump()
    {
        $tempFile = $this->backupPath . '/temp_' . time() . '.sql';
        
        $database = config('database.connections.mysql.database');
        
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $database;
        
        $sql = "-- AERPharmacy Database Backup\n";
        $sql .= "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: " . $database . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
        
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            $sql .= $this->dumpTable($tableName);
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        File::put($tempFile, $sql);
        return $tempFile;
    }

    protected function dumpTable($table)
    {
        $result = "-- Table: {$table}\n";
        $result .= "DROP TABLE IF EXISTS `{$table}`;\n";
        
        $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
        $result .= $createTable[0]->{'Create Table'} . ";\n\n";
        
        $rows = DB::table($table)->get();
        if ($rows->count() > 0) {
            $columns = array_keys((array)$rows->first());
            $columnList = '`' . implode('`, `', $columns) . '`';
            
            foreach ($rows as $row) {
                $values = [];
                foreach ($columns as $col) {
                    $value = $row->$col;
                    if ($value === null) {
                        $values[] = 'NULL';
                    } elseif (is_numeric($value) && !is_string($value)) {
                        $values[] = $value;
                    } else {
                        $values[] = "'" . addslashes($value) . "'";
                    }
                }
                $result .= "INSERT INTO `{$table}` ({$columnList}) VALUES (" . implode(', ', $values) . ");\n";
            }
            $result .= "\n";
        }
        
        return $result;
    }

    protected function createZipFile($zipPath, $sqlFile)
    {
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFile($sqlFile, 'database.sql');
            $zip->close();
        } else {
            throw new \Exception('Failed to create ZIP file.');
        }
    }

    protected function cleanOldBackups()
    {
        $retentionDays = (int) Setting::get('backup_retention', 30);
        $cutoff = now()->subDays($retentionDays);
        
        $oldBackups = Backup::where('status', 'success')
            ->where('completed_at', '<', $cutoff)
            ->get();
        
        foreach ($oldBackups as $backup) {
            $filePath = storage_path('app/' . $backup->file_path);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $backup->delete();
        }
    }

    protected function updateNextBackup()
    {
        $schedule = Setting::get('backup_schedule', 'weekly');
        $lastBackup = Backup::getLastSuccessful();
        
        if (!$lastBackup || $schedule === 'disabled') {
            Setting::set('backup_next_schedule', null);
            return;
        }
        
        $nextDate = $lastBackup->completed_at->copy();
        switch ($schedule) {
            case 'daily':
                $nextDate->addDay();
                break;
            case 'weekly':
                $nextDate->addWeek();
                break;
            case 'monthly':
                $nextDate->addMonth();
                break;
            default:
                Setting::set('backup_next_schedule', null);
                return;
        }
        
        Setting::set('backup_next_schedule', $nextDate);
    }

    protected function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}