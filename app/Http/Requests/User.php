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
            'email' => 'nullable|email|unique:users,email,' . $this->user()->id,
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,' . $this->user()->id,
            'dni' => 'required|string|unique:users,dni,' . $this->user()->id,
            'cuit' => 'nullable|string|unique:users,cuit,' . $this->user()->id,
        ];
    }
}
