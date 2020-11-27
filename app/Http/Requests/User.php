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
            'email' => 'required|integer|unique:users,email',
            'password' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string|unique:users,phone',
            'dni' => 'required|string|unique:users,dni',
            'cuit' => 'required|string|unique:users,cuit',
        ];
    }
}
