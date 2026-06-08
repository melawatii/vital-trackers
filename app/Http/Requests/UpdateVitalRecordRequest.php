<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Validation rules for updating a vital record */
    public function rules(): array
    {
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
