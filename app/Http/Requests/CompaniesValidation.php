<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesValidation extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {

        return [
            'name'=>'required',
            'email' => 'nullable|email',
            'logo'=>'nullable|image|dimensions:width=100,height=100',
            'website'=>'nullable|url'
        ];
    }
}
