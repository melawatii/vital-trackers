<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * Handle verification email notification.
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send verification email.
     */
    public function store(
        Request $request
    ): RedirectResponse {

        /**
         * Prevent duplicate verification.
         */
        if (
            $request
                ->user()
                ->hasVerifiedEmail()
        ) {

            return redirect()
                ->route('dashboard');
        }

        /**
         * Send verification notification.
         */
        $request
            ->user()
            ->sendEmailVerificationNotification();

        /**
         * Store activity log.
         */
        activity_log(
            'verification_email',
            'User resend verification email.'
        );

        return back()->with(
            'status',
            'verification-link-sent'
        );
    }
}