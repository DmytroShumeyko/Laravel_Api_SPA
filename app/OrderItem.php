<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    public function company(){
        return $this->belongsTo(Order::class);
    }
}
