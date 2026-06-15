<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Controller responsible for handling email verification confirmations.
 */
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Only proceed if the user's email has not already been verified
        if (! $request->user()->hasVerifiedEmail()) {
            // Set the email_verified_at timestamp to the current time
            $request->user()->forceFill([
                'email_verified_at' => now(),
            ])->save();

            // Dispatch the Verified event to notify the system (e.g., for listeners)
            event(new Verified($request->user()));
        }

        // Redirect to the dashboard with a success flash message
        return redirect()->route('dashboard')->with('success', 'Email verified successfully.');
    }
}