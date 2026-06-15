<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

/**
 * Controller responsible for managing user password updates.
 */
class PasswordController extends Controller
{
    /**
     * Update the authenticated user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate inputs using a named error bag to isolate errors from other forms on the same page
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Hash the new password and securely update the user's record
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Log the password update activity for security auditing purposes
        activity_log('update_password', 'User updated account password.');

        // Redirect back with a status flag to display a success message to the user
        return back()->with('status', 'password-updated');
    }
}