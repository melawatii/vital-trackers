<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVitalTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Validation rules for updating a vital type */
    public function rules(): array
    {
        $id = $this->route('vital_type');

        return [
            'name'              => ['required', 'string', 'max:100', "unique:vital_types,name,{$id},_id"],
            'slug'              => ['nullable', 'string', 'max:120'],
            'category_id'       => ['required', 'string'],
            'input_type'        => ['required', 'in:number,text,boolean,scale'],
            'unit'              => ['required', 'string', 'max:20'],
            'min_value'         => ['required', 'numeric'],
            'max_value'         => ['required', 'numeric', 'gte:min_value'],
            'normal_range_min'  => ['required', 'numeric'],
            'normal_range_max'  => ['required', 'numeric', 'gte:normal_range_min'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'note'              => ['nullable', 'string', 'max:500'],
            'status'            => ['required', 'in:active,inactive'],
        ];
    }

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
