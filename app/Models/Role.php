<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongToMany('App\Models\User')->withTimestamps();;
    }
}


//return $this->belongsToMany('App\Productversion')->withPivot('product_id', 'quantity', 'discount_percent', 'discount_amount')->withTimestamps();



