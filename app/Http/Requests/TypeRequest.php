<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
