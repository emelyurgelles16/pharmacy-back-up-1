<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public function logActivity($action, $module, $description, $oldData = null, $newData = null)
    {
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username ?? auth()->user()->name ?? 'System',
            $action,
            $module,
            $description,
            $oldData,
            $newData
        );
    }
}