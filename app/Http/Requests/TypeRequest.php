<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_candybar'       => filter_var($this->is_candybar ?? false, FILTER_VALIDATE_BOOLEAN),
            'is_candybar_group' => filter_var($this->is_candybar_group ?? false, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:255',
            'weight_quantity'   => 'required|in:weight,quantity',
            'is_candybar'       => 'boolean',
            'is_candybar_group' => 'boolean',
            'image'             => 'nullable|image|max:5120',
        ];
    }
}
