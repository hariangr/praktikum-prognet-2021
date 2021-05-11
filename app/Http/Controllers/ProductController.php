<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_categories;
use App\Models\Product_category_details;
use App\Models\Product_images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('product-list',compact(['product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_categories = Product_categories::all();
        return view('product-new',compact(['product_categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->product_rate = $request->product_rate;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->save();
        
        $product_category_details = new Product_category_details;
        $product_category_details->product_id = $product->id;
        $product_category_details->category_id = $request->category_name;
        $product_category_details->save();
     
        $file = $request->file('image_name');
        $product_images = new Product_images;
        $product_images->product_id = $product->id;
        $product_images->image_name = $file->getClientOriginalName();
        $product_images->save();

        $file->move('img',$file->getClientOriginalName());

        return redirect('/adminproduct')->with('message', 'Data Produk Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $adminproduct)
    {
        $product = $adminproduct;
        $id = $product->id;
        $product_images = Product_images::select('image_name')->where('product_id',$id)->first();
        $product_categories = Product_categories::all();
        $product_category_details = Product_category_details::select('category_id')->where('product_id',$id)->first();
        return view('product-view',compact(['product','product_images','product_categories','product_category_details','id']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $adminproduct)
    {
        $product = $adminproduct;
        $id = $product->id;
        $product_images = Product_images::select('image_name')->where('product_id',$id)->first();
        $product_categories = Product_categories::all();
        $product_category_details = Product_category_details::select('category_id')->where('product_id',$id)->first();
        return view('product-edit',compact(['product','product_images','product_categories','product_category_details','id']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $adminproduct)
    {
        $product = $adminproduct;
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->product_rate = $request->product_rate;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->save();
        
        $id = $product->id;
        $product_category_details = new Product_category_details;
        Product_category_details::where('product_id',$id)->delete();
        $product_category_details->product_id = $product->id;
        $product_category_details->category_id = $request->category_name;
        $product_category_details->save();

        if(!empty($request->image_name)){
            $file = $request->file('image_name');
            $product_images = new Product_images;
            Product_images::where('product_id',$id)->delete();
            $product_images->product_id = $product->id;
            $product_images->image_name = $file->getClientOriginalName();
            $product_images->save();
    
            $file->move('img',$file->getClientOriginalName());
            return redirect('/adminproduct')->with('message', 'Data Produk Berhasil Ditambahkan');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filename=Product_images::select('image_name')->where('product_id',$id)->first();
        File::delete('img/'.$filename);

        Product_images::where('product_id',$id)->delete();
        Product_category_details::where('product_id',$id)->delete();

        Product::where('id',$id)->delete();
        return redirect('/adminproduct')->with('message', 'Data Produk Berhasil Dihapus');
    }
}
