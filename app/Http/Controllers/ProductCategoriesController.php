<?php

namespace App\Http\Controllers;

use App\Models\Product_categories;
use Illuminate\Http\Request;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_categories = Product_categories::all();
        return view('product_categories-list',compact(['product_categories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_categories-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_categories = new Product_categories;
        $product_categories->category_name = $request->category_name;
        
        $product_categories->save();
       
        return redirect('/adminproductcategories')->with('message', 'Data Kategori Produk Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product_categories  $product_categories
     * @return \Illuminate\Http\Response
     */
    public function show(Product_categories $product_categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_categories  $product_categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_categories $product_categories)
    {
        return view('product_categories-edit',compact(['product_categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_categories  $product_categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_categories $product_categories)
    {
        $product_categories->category_name = $request->category_name;
        
        $product_categories->save();
       
        return redirect('/adminproductcategories')->with('message', 'Data Kategori Produk Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_categories  $product_categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product_categories::where('id',$id)->delete();
        return redirect('/adminproductcategories')->with('message', 'Data Kategori Produk Berhasil Dihapus');
    }
}
