<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestPassword extends FormRequest
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
            'password_old' => 'required',
            'password' => 'required',
            'password_comfirm' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'password_old.required' => 'Không được để trống',
            'password.required' =>  'Không được để trống',
            'password_comfirm.required' =>  'Không được để trống',
        ];
    }
}
