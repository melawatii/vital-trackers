<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating and authorizing vital category updates.
 */
class UpdateVitalCategoryRequest extends FormRequest
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
        // Extract the category ID from the route to exclude the current record from the unique check (MongoDB _id)
        $id = $this->route('vital_category');

        return [
            // Ensure name is unique, but ignore the current category's ID
            'name'        => ['required', 'string', 'max:100', "unique:vital_categories,name,{$id},_id"],
            'description' => ['required', 'string', 'max:500'],
            'icon'        => ['required', 'string'],
            'status'      => ['required', 'in:active,inactive'],
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
            'name.required'   => 'Category name is required.',
            'name.unique'     => 'This category name already exists.',
            'icon.required'   => 'Please select a category icon.',
            'status.required' => 'Please select a status.',
        ];
    }
}
