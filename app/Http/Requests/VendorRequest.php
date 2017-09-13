<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required',
            'owner' => '',
            'phone' => '',
            'email' => 'required|unique:vendors,email,'.$this->get('id'),
            'site' => '',
            'address' => '',
            'current_account' => '',
            'bank' => '',
            'town' => '',
            'mfo' => '',
            'itn' => '',
            'tax' => ''
        ];
    }
}
