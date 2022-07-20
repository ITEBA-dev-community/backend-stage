<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nim' => 'required',
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nim.required' => 'Nim tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];
    }

   
}
