<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'companies_id'=>'',
            'email'=>'nullable|email',
            'phone'=>'nullable',
        ];
    }
}
