<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_remate',
        'date_delivery',
        'quantity',
        'price_unit',
        'partial_total',
        'commission_percentage',
        'commission_value',
        'partial_payment',
        'total',
        'user_id',
        'sale_order_id',
        'product_id'
    ];

    public function saleOrder()
    {
        return $this->belongsTo('App\Models\SaleOrder');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
