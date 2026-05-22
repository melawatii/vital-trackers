<?php

namespace App\Observers;

use App\Models\User;

use App\Models\VitalRecord;

/**
 * Handle user model events.
 */
class UserObserver
{
    /**
     * Handle deleting user event.
     */
    public function deleting(
        User $user
    ): void {

        /**
         * Delete all related
         * vital records.
         */
        VitalRecord::where(

            'user_id',

            (string) $user->_id

        )->delete();
    }
}