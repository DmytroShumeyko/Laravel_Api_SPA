<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'phone' => '',
            'email' => 'required|unique:users,email,'.$this->get('id'),
            'site' => '',
            'address' => '',
            'current_account' => '',
            'bank' => '',
            'town' => '',
            'mfo' => '',
            'itn' => '',
        ];
    }
}
