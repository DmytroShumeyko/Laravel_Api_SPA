<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
    public function rules() :array
    {
        return [
            'company.name' => 'required',
            'company.owner' => '',
            'company.phone' => '',
            'company.email' => 'required|unique:companies,email,'.$this->get('id'),
            'company.site' => '',
            'company.address' => '',
            'company.current_account' => '',
            'company.bank' => '',
            'company.town' => '',
            'company.mfo' => '',
            'company.itn' => '',
            'company.tax' => ''
        ];
    }
}
