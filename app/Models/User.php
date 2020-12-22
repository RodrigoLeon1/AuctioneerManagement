<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;
    use SoftDeletes;
    use Notifiable;

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'lastname',
        'email',
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
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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

    public function isAdmin()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function isCliente()
    {
        return $this->roles()->where('id', 2)->exists();
    }

    public function isRemitente()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('description', $role)->first()) {
            return true;
        }
        return false;
    }
}
