<?php

namespace App\Http\Controllers;

use App\Models\discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = discount::all();
        return view ("discount-list",compact(['discount']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::all();
        return view ("discount-new",compact(['product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = new discount;
        $discount->id_product = $request->id_product;
        $discount->percentage = $request->percentage;
        $discount->start = $request->start;
        $discount->end = $request->end;
        $discount->save();

        return redirect('/admindiscount')->with('message', 'Data Discount Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(discount $admindiscount)
    {
        $product = Product::all();
        $discount = $admindiscount;
        return view ("discount-view",compact(['discount','product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(discount $admindiscount)
    {
        $product = Product::all();
        $discount = $admindiscount;
        return view ("discount-edit",compact(['discount','product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, discount $admindiscount)
    {
        $discount = $admindiscount;
        $discount->id_product = $request->id_product;
        $discount->percentage = $request->percentage;
        $discount->start = $request->start;
        $discount->end = $request->end;
        $discount->save();

        return redirect('/admindiscount')->with('message', 'Data Discount Berhasil Ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        discount::where('id',$id)->delete();
        return redirect('/admindiscount')->with('message', 'Data Discount Berhasil Dihapus');
    }
}
