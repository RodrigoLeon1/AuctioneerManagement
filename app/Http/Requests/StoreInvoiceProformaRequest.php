<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceProformaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date_remate' => 'required|date|after_or_equal:start_date',
            'date_delivery' => 'required|date|after_or_equal:start_date',
            'quantity' => 'required|numeric',
            'price_unit' => 'required|numeric',
            'partial_total' => 'required|numeric',
            'commission_percentage' => 'required|numeric',
            'commission_value' => 'required|numeric',
            'partial_payment' => 'required|numeric',
            'total' => 'required|numeric',
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
