<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
    public function saleItem(){
        return $this->hasMany(SaleItem::class);
    }
    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
    public function productsHistory(){
        return $this->hasMany(ProductHistory::class);
    }
    public static function getProducts(){
        return auth()->user()->products;
    }

}
