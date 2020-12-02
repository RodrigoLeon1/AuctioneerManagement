<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'email|string|unique:users,email',
            'password' => 'string|min:8',
            'address' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'phone' => 'string|unique:users,phone',
            'dni' => 'string|unique:users,dni',
            'cuit' => 'string|unique:users,cuit',
        ];
    }
}
