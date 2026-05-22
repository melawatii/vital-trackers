<?php

namespace App\Http\Requests\Auth;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\RateLimiter;

use Illuminate\Auth\Events\Lockout;

use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Handle login authentication request.
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine request authorization.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'email' => [
                'required',
                'string',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Authenticate login credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        /**
         * Prevent brute force request.
         */
        $this->ensureIsNotRateLimited();

        /**
         * Normalize email input.
         */
        $this->merge([

            'email' => strtolower(
                $this->email
            )
        ]);

        /**
         * Attempt user authentication.
         */
        if (
            !Auth::attempt(

                $this->only(
                    'email',
                    'password'
                ),

                $this->boolean('remember')
            )
        ) {

            /**
             * Increase failed attempt counter.
             */
            RateLimiter::hit(
                $this->throttleKey()
            );

            /**
             * Throw validation exception.
             */
            throw ValidationException::withMessages([

                'email' => trans(
                    'auth.failed'
                ),
            ]);
        }

        /**
         * Clear rate limiter.
         */
        RateLimiter::clear(
            $this->throttleKey()
        );
    }

    /**
     * Ensure login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        /**
         * Check login attempt limit.
         */
        if (
            !RateLimiter::tooManyAttempts(
                $this->throttleKey(),
                5
            )
        ) {

            return;
        }

        /**
         * Trigger lockout event.
         */
        event(
            new Lockout($this)
        );

        /**
         * Get remaining lock duration.
         */
        $seconds = RateLimiter::availableIn(
            $this->throttleKey()
        );

        /**
         * Throw throttle validation error.
         */
        throw ValidationException::withMessages([

            'email' => trans(

                'auth.throttle',

                [
                    'seconds' => $seconds,

                    'minutes' => ceil(
                        $seconds / 60
                    ),
                ]
            ),
        ]);
    }

    /**
     * Generate throttle key.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(

            Str::lower(
                $this->string('email')
            )

            . '|' .

            $this->ip()
        );
    }
}