<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Controller responsible for handling email verification notification requests.
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Prevent duplicate verification emails if the user is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        // Dispatch the verification email to the user's registered address
        $request->user()->sendEmailVerificationNotification();

        // Log the email verification resend activity
        activity_log('verification_email', 'User resend verification email.');

        // Redirect back with a status flag to display the 'link sent' alert to the user
        return back()->with('status', 'verification-link-sent');
    }
}
