<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Validation rules for updating a vital category */
    public function rules(): array
    {
        $id = $this->route('vital_category');

        return [
            'name'        => ['required', 'string', 'max:100', "unique:vital_categories,name,{$id},_id"],
            'description' => ['required', 'string', 'max:500'],
            'icon'        => ['required', 'string'],
            'status'      => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Category name is required.',
            'name.unique'     => 'This category name already exists.',
            'icon.required'   => 'Please select a category icon.',
            'status.required' => 'Please select a status.',
        ];
    }
}
