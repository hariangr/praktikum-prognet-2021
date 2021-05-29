<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\City;
use App\Models\Courier;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionsDetail;
use App\Notifications\NewTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->where('status', 'notyet')->get();

        $provinces = Province::all();
        $cities = City::all();
        $courier = Courier::all();

        $price = 0;
        $total = 0;
        $berat_total = 0;
        $sub_price = 0;

        $carts = Cart::where('user_id', Auth::user()->id)->where('status', 'notyet')->get();
        foreach ($carts as $cart) {
            foreach ($cart->product->diskon as $diskon) {
                if (date('Y-m-d') >= $diskon->start && date('Y-m-d') < $diskon->end) {
                    $price = $cart->produk->price - ($diskon->percentage / 100 * $cart->produk->price);
                    $total += $price * $cart->qty;
                    break;
                }
            }
            if ($price == 0) {
                $total += $cart->product->price * $cart->qty;
            }
            $berat_total = $berat_total + ($cart->product->weight * $cart->qty);
        }


        return view('user.cart', compact('carts', 'provinces', 'cities', 'courier', 'berat_total', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exist = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request['product_id'])
            ->where('status', 'notyet')
            ->first();
        if ($exist != null) {
            // Sudah ada, tambahkan qty
            $exist['qty'] = $exist['qty'] + 1;
            $exist->save();
        } else {
            $cart = Cart::create([
                "user_id" => Auth::user()->id,
                "product_id" => $request['product_id'],
                "qty" => 1,
                "status" => 'notyet',
            ]);
            $cart->save();
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }


    public function checkout(Request $request)
    {
        $add_24h = Carbon::now()->addDay(1);
        $address = $request['address'];
        $regency = $request['cities'];
        $province = $request['province'];
        $shipping_cost = $request['courier_service'];
        $total = $request['total'];
        $courier_code = $request['courier'];
        $status = null;

        $sub_total = $total + $shipping_cost;

        $courier = Courier::where("courier", $courier_code)->first();

        $new_trans = Transaction::create([
            "timeout" => $add_24h,
            "address" => $address,
            "regency" => $regency,
            "province" => $province,
            "total" => $total,
            "sub_total" => $sub_total,
            "shipping_cost" => $shipping_cost,
            "user_id" => Auth::user()->id,
            "courier_id" => $courier->id,
            "status" => $status,
        ]);

        $itemsInCartNotYet = Cart::where('user_id', Auth::user()->id)->where('status', 'notyet')->get();
        foreach ($itemsInCartNotYet as $it) {
            $discount_int = null;
            foreach ($it->product->diskon as $diskon) {
                if (date('Y-m-d') >= $diskon->start && date('Y-m-d') < $diskon->end) {
                    $discount_int = $diskon->percentage;
                    break;
                }
            }

            if ($discount_int != null && $discount_int > 0) {
                $harga_after_discount = ($discount_int / 100) * $it->product->price;
                $hargaQty = $harga_after_discount * $it->qty;
            } else {
                $harga_after_discount = $it->product->price;
                $hargaQty = $harga_after_discount * $it->qty;
            }

            TransactionDetail::create([
                "transaction_id" => $new_trans->id,
                "product_id" => $it->product_id,
                "qty" => $it->qty,
                "discount" => $discount_int,
                "selling_price" => $hargaQty,
            ]);

            Cart::where('id', $it->id)->update([
                'status' => 'checkedout',
            ]);
        }

        $allAdmins = Admin::all();
        foreach ($allAdmins as $it) {
            $it->notify(new NewTransaction($new_trans->id));
        }

        return redirect(route('transaction.show', $new_trans->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        Cart::destroy($cart->id);
        return redirect('/produk/cart');
    }
}
