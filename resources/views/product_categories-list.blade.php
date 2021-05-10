@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Product Categories</h1>
  <h2>List Product Categories</h2> 
</div>

@endsection

@section('page-contents')
    <p>
        <button type="button" class="btn btn-primary" onclick="location.href='/adminproductcategories/create'">Tambah Kategori Produk</button>
    </p>
    <p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori Produk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product_categories as $pc)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$pc->category_name}}</td>
                        <td>
                            <form action="/adminproductcategories/{{$pc->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-info" onclick="location.href='/adminproductcategories/{{$pc->id}}/edit'">Edit</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </p>
    <button type="button" class="btn btn-primary" onclick="location.href='/admindashboard'">Kembali</button>
    
@endsection