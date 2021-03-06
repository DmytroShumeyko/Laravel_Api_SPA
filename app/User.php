<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
//    protected $fillable = [
//        'name', 'email', 'password', 'phone', 'site', 'address', 'current_account', 'bank', 'town', 'mfo', 'itn'
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Vendor::class)->orderBy('id', 'desc');
    }

    public function productsHistory()
    {
        return $this->hasManyThrough(ProductHistory::class, Vendor::class)->orderBy('id', 'desc');
    }

    public function sales()
    {
        return $this->hasManyThrough(Sale::class, Company::class)->orderBy('date', 'desc');
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Company::class)->orderBy('date', 'desc');
    }

}
