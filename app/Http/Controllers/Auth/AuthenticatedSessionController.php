<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller responsible for handling user authentication sessions.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to authenticate the user using the LoginRequest rules
        $request->authenticate();

        // Regenerate the session ID to prevent session fixation attacks
        $request->session()->regenerate();

        // Update the user's last login timestamp
        if (Auth::check()) {
            Auth::user()->update(['last_login_at' => now()]);
        }

        // Log the successful login activity
        activity_log('login', 'User logged into application.');

        // Redirect to the intended URL or fall back to the dashboard
        return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session (Log out the user).
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the logout activity before terminating the session
        activity_log('logout', 'User logged out from application.');

        // Invalidate the user's authentication session
        Auth::guard('web')->logout();

        // Invalidate the entire session to clear all data
        $request->session()->invalidate();

        // Regenerate the CSRF token to prevent CSRF attacks on the next request
        $request->session()->regenerateToken();

        // Redirect to the application's root path
        return redirect('/');
    }
}
