<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

/**
 * Handle email verification.
 */
class VerifyEmailController extends Controller
{
    /**
     * Verify email address.
     */
    public function __invoke(
        EmailVerificationRequest $request
    ): RedirectResponse {

        // Check verified email
        if (! $request->user()->hasVerifiedEmail()) {

            // Update verification timestamp
            $request->user()->forceFill([
                'email_verified_at' => now(),
            ])->save();

            // Trigger verified event
            event(
                new Verified(
                    $request->user()
                )
            );
        }

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Email verified successfully.'
            );
    }
}