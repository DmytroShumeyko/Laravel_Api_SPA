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
            'vendor.name' => 'required',
            'vendor.owner' => '',
            'vendor.phone' => '',
            'vendor.email' => 'required|unique:vendors,email,'.$this->get('id'),
            'vendor.site' => '',
            'vendor.address' => '',
            'vendor.current_account' => '',
            'vendor.bank' => '',
            'vendor.town' => '',
            'vendor.mfo' => '',
            'vendor.itn' => ''
        ];
    }
}
