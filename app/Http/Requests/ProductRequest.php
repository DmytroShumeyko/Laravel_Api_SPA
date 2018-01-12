<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product.name' => 'required',
            'product.cost' => 'required|numeric',
            'product.price' => 'required|numeric',
            'product.description' => '',
            'product.image' => ''
        ];
    }
}
