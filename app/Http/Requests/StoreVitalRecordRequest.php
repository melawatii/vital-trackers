<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVitalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Validation rules for creating a vital record */
    public function rules(): array
    {
        $rules = [
            'type_id'     => ['required', 'string'],
            'category_id' => ['required', 'string'],
            'value'       => ['required', 'numeric'],
            'unit'        => ['required', 'string', 'max:20'],
            'status'      => ['required', 'in:normal,high_low'],
            'note'        => ['nullable', 'string', 'max:500'],
            'recorded_at' => ['required', 'date'],
        ];

        // Admin can specify user_id; otherwise it's set to auth()->id()
        if (auth()->check() && auth()->user()->role === 'admin') {
            $rules['user_id'] = ['nullable', 'string', 'exists:users,_id'];
        }

        return $rules;
    }

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
