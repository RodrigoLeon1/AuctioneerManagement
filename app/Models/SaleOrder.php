<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;

    protected $dates = [
        'updated_at',
        'created_at',
    ];

    protected $fillable = [
        'date_set',
        'remito',
        'date_payment',
        'order_number',
        'user_id'
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')
            ->withPivot('quantity', 'quantity_tags')
            ->withTimestamps();
    }
}
