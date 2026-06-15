<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating and authorizing vital record updates.
 */
class UpdateVitalRecordRequest extends FormRequest
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
        // Note: user_id is intentionally omitted as the owner of a record should not be changed post-creation
        return [
            'type_id'     => ['required', 'string'],
            'category_id' => ['required', 'string'],
            'value'       => ['required', 'numeric'],
            'unit'        => ['required', 'string', 'max:20'],
            'status'      => ['required', 'in:normal,high_low'],
            'note'        => ['nullable', 'string', 'max:500'],
            'recorded_at' => ['required', 'date'],
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
            'type_id.required'     => 'Please select a vital type.',
            'category_id.required' => 'Please select a category.',
            'value.required'       => 'Measurement value is required.',
            'value.numeric'        => 'Measurement value must be a number.',
            'recorded_at.required' => 'Date and time is required.',
        ];
    }
}
