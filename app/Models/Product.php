<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function saleorder()
    {
        return $this->belongsToMany('App\Models\SaleOrder')
            ->withPivot('quantity', 'quantity_sold', 'quantity_remaining', 'quantity_tags')
            ->withTimestamps();
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoice')
            ->withPivot('quantity', 'price_unit', 'total')
            ->withTimestamps();
    }
}
