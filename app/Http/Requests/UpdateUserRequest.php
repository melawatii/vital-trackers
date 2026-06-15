<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating and authorizing user updates.
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Allow all authorized users to make this request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // Extract the user ID from the route to exclude the current record from the unique email check (MongoDB _id)
        $id = $this->route('user');

        return [
            'name'     => ['required', 'string', 'max:100'],
            // Ensure email is unique, but ignore the current user's ID
            'email'    => ['required', 'email', 'max:150', "unique:users,email,{$id},_id"],
            // Password is optional on update, but must meet minimum length and confirmation if provided
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:admin,user'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'Full name is required.',
            'email.unique'       => 'This email address is already registered.',
            'password.min'       => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
