<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'code' => ['nullable', 'string', 'max:255', Rule::unique('menus', 'code')],
                    'parent_id' => ['nullable', 'uuid', 'exists:menus,id'],
                    'order' => ['nullable', 'integer', 'min:0'],
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'name' => ['sometimes', 'required', 'string', 'max:255'],
                    'code' => [
                        'nullable',
                        'string',
                        'max:255',
                        Rule::unique('menus', 'code')->ignore($id),
                    ],
                    'parent_id' => ['nullable', 'uuid', 'exists:menus,id'],
                    'order' => ['nullable', 'integer', 'min:0'],
                ];

            default:
                return [];
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Menu name is required.',
            'name.string' => 'Menu name must be a string.',
            'code.unique' => 'Menu code already exists.',
            'parent_id.exists' => 'Parent menu not found.',
            'order.integer' => 'Order must be a valid integer.',
        ];
    }
}