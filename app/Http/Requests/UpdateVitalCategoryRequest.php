<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a vital category.
     * Ignores unique check for the current record being updated.
     */
    public function rules(): array
    {
        $id = $this->route('vital_category')?->id ?? $this->route('vital_category');

        return [
            'name'        => ['required', 'string', 'min:2', 'max:100', "unique:vital_categories,name,{$id}"],
            'icon'        => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'min:5', 'max:500'],
            'status'      => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required'        => 'Category name is required.',
            'name.unique'          => 'This category name already exists.',
            'name.min'             => 'Category name must be at least 2 characters.',
            'icon.required'        => 'Please select an icon for this category.',
            'description.required' => 'Description is required.',
            'description.min'      => 'Description must be at least 5 characters.',
            'status.required'      => 'Status is required.',
            'status.in'            => 'Status must be either active or inactive.',
        ];
    }
}
