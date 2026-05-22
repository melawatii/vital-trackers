<?php

use App\Models\ActivityLog;

/**
 * Store activity log.
 */
function activity_log(
    string $action,
    string $description
): void {

    /**
     * Prevent guest logging error.
     */
    if (!auth()->check()) {
        return;
    }

    ActivityLog::create([

        'user_id' => (string) auth()->user()->_id,

        'action' => $action,

        'description' => $description,

        'ip_address' => request()->ip(),

        'user_agent' => request()->userAgent(),
    ]);
}