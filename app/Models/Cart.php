<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "carts";

    public function produk(){
        return $this->belongsTo(Products::class, 'product_id','id');
    }
}
