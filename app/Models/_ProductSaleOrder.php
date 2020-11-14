<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSaleOrder extends Model
{
    protected $fillable = [
        'quantity',
        'quantity_tags',
        'is_invoiced'
    ];
}
