<?php

namespace App\Policies;

use App\Models\User;

use App\Models\VitalRecord;

/**
 * Handle vital record authorization.
 */
class VitalRecordPolicy
{
    /**
     * Determine view permission.
     */
    public function view(
        User $user,
        VitalRecord $record
    ): bool {

        /**
         * Admin can access all data.
         */
        if (
            $user->role === 'admin'
        ) {

            return true;
        }

        /**
         * User only access own data.
         */
        return $record->user_id
            == (string) $user->_id;
    }

    /**
     * Determine update permission.
     */
    public function update(
        User $user,
        VitalRecord $record
    ): bool {

        /**
         * Admin can update all data.
         */
        if (
            $user->role === 'admin'
        ) {

            return true;
        }

        /**
         * User only update own data.
         */
        return $record->user_id
            == (string) $user->_id;
    }

    /**
     * Determine delete permission.
     */
    public function delete(
        User $user,
        VitalRecord $record
    ): bool {

        /**
         * Admin can delete all data.
         */
        if (
            $user->role === 'admin'
        ) {

            return true;
        }

        /**
         * User only delete own data.
         */
        return $record->user_id
            == (string) $user->_id;
    }

    /**
     * Determine export permission.
     */
    public function export(
        User $user
    ): bool {

        return in_array(

            $user->role,

            [
                'admin',
                'user'
            ]
        );
    }
}