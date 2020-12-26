<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'nullable|email|unique:users,email,' . $this->route('usuario'),
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,' . $this->route('usuario'),
            'dni' => 'required|string|unique:users,dni,' . $this->route('usuario'),
            'cuit' => 'nullable|string|unique:users,cuit,' . $this->route('usuario'),
        ];
    }
}
