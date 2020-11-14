<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        // 'email_verified_at',
        'created_at',
        'updated_at',
        // 'deleted_at',
    ];

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'address',
        'postal_code',
        'city',
        'phone',
        'dni',
        'cuit'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // 'deleted_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();;
    }

    public function saleorders()
    {
        return $this->hasMany('App\Models\SaleOrder');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function getIsAdmin()
    {
        return $this->roles()->where('id', 1)->exists();
    }
}
