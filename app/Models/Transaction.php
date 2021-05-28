<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['discount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailTransactions()
    {
        return $this->hasMany(TransactionsDetail::class, 'transaction_id', 'id');
    }

    public function getProofOfPayment()
    {
        return $this->proof_of_payment ? asset('storage/img/buktipembayaran/' . $this->proof_of_payment) : asset('img-001.jpg');
    }
}
