<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = "products";

    public function diskon()
    {
        return $this->hasMany(Discount::class, 'id_product', 'id')->orderBy('id', 'desc')->limit('1');
    }

    public function my_cart()
    {
        $exist = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $this->id)
            ->where('status', 'notyet')
            ->first();
        return $exist;
    }
}
