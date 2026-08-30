<?php
// app/Console/Commands/CreateBackupCommand.php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Services\BackupService;
use Illuminate\Console\Command;

class CreateBackupCommand extends Command
{
    protected $signature = 'backup:create';
    protected $description = 'Create a database backup';

    protected $backupService;

    public function __construct(BackupService $backupService)
    {
        parent::__construct();
        $this->backupService = $backupService;
    }

    public function handle()
    {
        $schedule = Setting::get('backup_schedule', 'weekly');
        
        if ($schedule === 'disabled') {
            $this->info('Backup is disabled. Skipping...');
            return 0;
        }

        $this->info('Creating database backup...');
        $result = $this->backupService->createBackup('automatic');
        
        if ($result['success']) {
            $this->info('Backup created successfully: ' . $result['backup']->filename);
            return 0;
        } else {
            $this->error('Backup failed: ' . $result['message']);
            return 1;
        }
    }
}