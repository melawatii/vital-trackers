<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating and authorizing new vital record creation.
 */
class StoreVitalRecordRequest extends FormRequest
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
        // Define base validation rules for vital record fields
        $rules = [
            'type_id'     => ['required', 'string'],
            'category_id' => ['required', 'string'],
            'value'       => ['required', 'numeric'],
            'unit'        => ['required', 'string', 'max:20'],
            'status'      => ['required', 'in:normal,high_low'],
            'note'        => ['nullable', 'string', 'max:500'],
            'recorded_at' => ['required', 'date'],
        ];

        // Admin users can assign records to other users, so conditionally add user_id validation
        if (auth()->check() && auth()->user()->role === 'admin') {
            $rules['user_id'] = ['nullable', 'string', 'exists:users,_id'];
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type_id.required'     => 'Please select a vital type.',
            'category_id.required' => 'Please select a category.',
            'value.required'       => 'Measurement value is required.',
            'value.numeric'        => 'Measurement value must be a number.',
            'recorded_at.required' => 'Date and time is required.',
            'user_id.exists'       => 'The selected user does not exist.',
        ];
    }
}
