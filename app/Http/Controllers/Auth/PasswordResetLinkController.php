<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controller responsible for handling password reset link requests.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user's email.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the email address format
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Attempt to send the password reset link to the specified email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Check if the reset link was successfully dispatched
        if ($status == Password::RESET_LINK_SENT) {
            // Log the password reset request activity
            activity_log('send_reset_password', 'User requested reset password link.');

            // Redirect back with a status message to display the success notification
            return back()->with('status', __($status));
        }

        // If sending failed, redirect back with the input and an error message
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}