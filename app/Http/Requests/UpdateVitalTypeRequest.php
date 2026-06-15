<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for validating and authorizing vital type updates.
 */
class UpdateVitalTypeRequest extends FormRequest
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
        // Extract the vital type ID from the route to exclude the current record from the unique check (MongoDB _id)
        $id = $this->route('vital_type');

        return [
            // Ensure name is unique, but ignore the current vital type's ID
            'name'              => ['required', 'string', 'max:100', "unique:vital_types,name,{$id},_id"],
            'slug'              => ['nullable', 'string', 'max:120'],
            'category_id'       => ['required', 'string'],
            'input_type'        => ['required', 'in:number,text,boolean,scale'],
            'unit'              => ['required', 'string', 'max:20'],
            'min_value'         => ['required', 'numeric'],
            // Cross-field validation: max_value must be greater than or equal to min_value
            'max_value'         => ['required', 'numeric', 'gte:min_value'],
            'normal_range_min'  => ['required', 'numeric'],
            // Cross-field validation: normal_range_max must be greater than or equal to normal_range_min
            'normal_range_max'  => ['required', 'numeric', 'gte:normal_range_min'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'note'              => ['nullable', 'string', 'max:500'],
            'status'            => ['required', 'in:active,inactive'],
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
            'name.required'        => 'Vital type name is required.',
            'name.unique'          => 'This vital type name already exists.',
            'category_id.required' => 'Please select a category.',
            'max_value.gte'        => 'Maximum value must be greater than or equal to minimum value.',
            'normal_range_max.gte' => 'Normal range max must be greater than or equal to min.',
        ];
    }
}
