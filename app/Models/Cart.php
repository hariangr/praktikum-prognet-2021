<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "carts";

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }
}
