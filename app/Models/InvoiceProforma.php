<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProforma extends Model
{
    use HasFactory;

    public function saleOrder()
    {
        return $this->belongsTo('App\Models\SaleOrder');
    }
}
