<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFillingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'image' => ['image'],
            'type_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'unit_price' => ['integer'],
            'min_weight' => ['string'],
            'min_quantity' => ['integer'],
            'description' => ['string']
        ];
    }
}
