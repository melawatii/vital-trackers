<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

use App\Http\Requests\Auth\LoginRequest;

/**
 * Handle user authentication session.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Display login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function store(
        LoginRequest $request
    ): RedirectResponse {

        /**
         * Authenticate login request.
         */
        $request->authenticate();

        /**
         * Regenerate session.
         */
        $request
            ->session()
            ->regenerate();

        /**
         * Store activity log.
         */
        activity_log(
            'login',
            'User logged into application.'
        );

        /**
         * Redirect user.
         */
        return redirect()
            ->route('dashboard');
    }

    /**
     * Handle logout request.
     */
    public function destroy(
        Request $request
    ): RedirectResponse {

        /**
         * Store activity log.
         */
        activity_log(
            'logout',
            'User logged out from application.'
        );

        /**
         * Logout current user.
         */
        Auth::guard('web')->logout();

        /**
         * Invalidate session.
         */
        $request
            ->session()
            ->invalidate();

        /**
         * Regenerate CSRF token.
         */
        $request
            ->session()
            ->regenerateToken();

        return redirect('/');
    }
}