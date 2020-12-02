<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceProforma extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date_remate' => 'required|date|after_or_equal:start_date',
            'date_remate_delivery' => 'required|date|after_or_equal:start_date',
            'price_unit' => 'required|numeric',
            'partial_total' => 'required|numeric',
            'commission' => 'required|numeric',
            'partial_payment' => 'required|numeric',
            'total' => 'required|numeric',
        ];
    }
}
