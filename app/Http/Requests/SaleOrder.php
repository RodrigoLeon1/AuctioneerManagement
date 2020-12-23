<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleOrder extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date_set' => 'required|date|after_or_equal:start_date',        // not working after or equal
            'date_payment' => 'required|date|after_or_equal:start_date',    // not working after or equal
            'remito' => 'required|integer',
            'order_number' => 'required|integer|unique:sale_orders,order_number',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'city' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone',
            'dni' => 'required|string|unique:users,dni',
            'cuit' => 'nullable|string|unique:users,cuit'
        ];
    }
}
