<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateFillingRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3'],
            'image' => ['required', 'image'],
            'category_id' => ['required', 'integer'],
            'unit_price' => ['required', 'integer'],
            'min_weight' => ['required_without:min_quantity', 'string'],
            'min_quantity' => ['required_without:min_weight', 'integer'],
            'description' => ['required', 'string'],
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    // throw new HttpResponseException(response()->json([
    //     'success'   => false,
    //     'message'   => 'Validation errors',
    //     'data'      => $validator->errors()
    // ]));
    // }
}
