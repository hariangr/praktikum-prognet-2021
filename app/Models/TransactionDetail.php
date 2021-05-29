<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $guarded = [];

    public function transaction(){
        return $this->belongsTo(Transactions::class,'transaction_id','id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }


    
}
