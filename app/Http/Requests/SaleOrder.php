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
        ];
    }
}
