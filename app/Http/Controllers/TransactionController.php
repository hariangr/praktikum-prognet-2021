<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\UserStatusTransactionChanged;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myTrans = Transaction::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        // $waitingVerifications = Transaction::where('user_id', Auth::user()->id)
        //     ->whereIn('status', ['unverified', 'null'])
        //     ->get();
        // $onseller = Transaction::where('user_id', Auth::user()->id)
        //     ->where('status', 'verified')
        //     ->get();
        // $finish = Transaction::where('user_id', Auth::user()->id)
        //     ->whereIn('status', ['delivered', 'success'])
        //     ->get();
        // $faileds = Transaction::where('user_id', Auth::user()->id)
        //     ->whereIn('status', ['expired', 'cancelled'])
        //     ->get();
        return view('user.transactions.index', compact('myTrans'));
    }

    public function addPayment(Request $request)
    {
        Log::info($request);

        $trans = null;
        foreach ($request->file('bukti') as $bukti) {
            $fileName = md5(now()) . '_' . $bukti->getClientOriginalName();
            $bukti->move('img/bukti', $fileName);

            $trans = Transaction::find($request['idTransaksi']);
            $trans->proof_of_payment = $fileName;
            $trans->status = 'unverified';
            $trans->save();
        }

        // Way too hacky
        $pembeli = User::where('id', $trans->user_id)->first();
        $pembeli->notify(new UserStatusTransactionChanged($trans->id, $trans->status, 'unverified'));

        return back();
    }

    public function addRating(Request $request)
    {
        $trans_id = $request['trans_id'];
        $trans = Transaction::where('id', $trans_id)->first();

        $newRating = $request['newRating'];
        $content = $request['content'];

        foreach ($trans->detailTransactions as $it) {
            $newReview = ProductReview::create([
                "product_id" => $it->product_id,
                "user_id" => Auth::user()->id,
                "rate" => $newRating,
                "content" => $content,
            ]);
        }

        $trans['status'] = 'success';
        $trans->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $timeNow = Carbon::now();

        $allowReview = True;
        return view('user.transactions.show', compact('transaction', 'timeNow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
