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
    
    public function getOneDiscount() {
        foreach ($this->diskon as $diskon) {
            if (date('Y-m-d') >= $diskon->start && date('Y-m-d') < $diskon->end) {
                return $diskon;
            }
        }
    }

    public function my_cart()
    {
        $exist = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $this->id)
            ->where('status', 'notyet')
            ->first();
        return $exist;
    }


    public function getFirstImage(){
        $image = Product_images::where('product_id', $this->id)->first();
        return $image;
    }
    public function images(){
        return $this->hasMany(Product_images::class,'product_id','id');
    }

    public function categories(){
        return $this->belongsToMany(Product_categories::class,'product_category_details','product_id','category_id');
    }
}
