<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\View\View;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Events\Registered;

use Illuminate\Validation\Rules;

use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * Handle user registration.
 */
class RegisteredUserController extends Controller
{
    /**
     * Display register page.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Store user registration.
     *
     * @throws ValidationException
     */
    public function store(
        Request $request
    ): RedirectResponse {

        /**
         * Validate registration request.
         */
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /**
         * Create user account.
         */
        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

            'role' => 'user',

            'created_time' => now(),
        ]);

        /**
         * Trigger registered event.
         */
        event(
            new Registered($user)
        );

        /**
         * Login registered user.
         */
        Auth::login($user);

        /**
         * Store activity log.
         */
        activity_log(
            'register',
            'User registered new account.'
        );

        return redirect()
            ->route('dashboard');
    }
}