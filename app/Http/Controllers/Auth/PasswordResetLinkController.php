<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;

use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * Handle password reset link request.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Display forgot password page.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send reset password email link.
     *
     * @throws ValidationException
     */
    public function store(
        Request $request
    ): RedirectResponse {

        /**
         * Validate request.
         */
        $request->validate([

            'email' => [
                'required',
                'email',
            ],
        ]);

        /**
         * Send password reset link.
         */
        $status = Password::sendResetLink(

            $request->only('email')
        );

        /**
         * Handle success response.
         */
        if (
            $status == Password::RESET_LINK_SENT
        ) {

            /**
             * Store activity log.
             */
            activity_log(
                'send_reset_password',
                'User requested reset password link.'
            );

            return back()->with(
                'status',
                __($status)
            );
        }

        /**
         * Handle failed response.
         */
        return back()
            ->withInput(
                $request->only('email')
            )
            ->withErrors([
                'email' => __($status)
            ]);
    }
}