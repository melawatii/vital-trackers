<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Password;

use Illuminate\Validation\Rules;

use Illuminate\Validation\ValidationException;

use Illuminate\View\View;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

/**
 * Handle reset password operation.
 */
class NewPasswordController extends Controller
{
    /**
     * Display reset password page.
     */
    public function create(
        Request $request
    ): View {

        return view(
            'auth.reset-password',
            [
                'request' => $request
            ]
        );
    }

    /**
     * Store new password request.
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

            'token' => [
                'required'
            ],

            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /**
         * Reset password process.
         */
        $status = Password::reset(

            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function (
                User $user
            ) use (
                $request
            ) {

                /**
                 * Update user password.
                 */
                $user->forceFill([

                    'password' => Hash::make(
                        $request->password
                    ),

                    'remember_token' => Str::random(60),

                ])->save();

                /**
                 * Trigger password reset event.
                 */
                event(
                    new PasswordReset($user)
                );
            }
        );

        /**
         * Handle success response.
         */
        if (
            $status == Password::PASSWORD_RESET
        ) {

            return redirect()
                ->route('login')
                ->with(
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