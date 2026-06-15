<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controller responsible for handling password confirmation before sensitive actions.
 */
class ConfirmablePasswordController extends Controller
{
    /**
     * Display the password confirmation view.
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password for added security verification.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the provided password against the currently authenticated user's credentials
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Throw a validation exception if the password does not match
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Store the timestamp of the confirmation to remember the user verified their password
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect to the intended URL or fallback to the dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
