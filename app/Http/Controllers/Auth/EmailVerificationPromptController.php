<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * Display verification email prompt page.
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Handle incoming request.
     */
    public function __invoke(
        Request $request
    ): RedirectResponse|View {

        /**
         * Redirect verified users.
         */
        if (
            $request
                ->user()
                ->hasVerifiedEmail()
        ) {

            return redirect()
                ->route('dashboard');
        }

        return view('auth.verify-email');
    }
}