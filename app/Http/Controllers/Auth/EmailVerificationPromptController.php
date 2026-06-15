<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsible for prompting users to verify their email address.
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt or redirect if already verified.
     *
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // If the user has already verified their email, redirect them to the dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        // Otherwise, display the view prompting them to verify their email
        return view('auth.verify-email');
    }
}
