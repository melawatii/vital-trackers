<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalRecordRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,_id',
            'category_id' => 'required|exists:vital_categories,_id',
            'vital_type_id' => 'required|exists:vital_types,_id',
            'vital_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'value' => 'required|numeric',
            'status' => 'required|in:normal,high,low',
            'note' => 'nullable|string',
            'measured_at' => 'required|date',
        ];
    }
}
