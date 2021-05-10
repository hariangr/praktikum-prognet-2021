@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Products</h1>
  <h2>List Products</h2> 
</div>

@endsection

@section('page-contents')
    <p>
        <button type="button" class="btn btn-primary" onclick="location.href='/adminproduct/create'">Tambah Produk</button>
    </p>
    <p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga Produk</th>
                    <th>Deskripsi Produk</th>
                    <th>Rate Produk</th>
                    <th>Stok Produk</th>
                    <th>Berat Produk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product as $p)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$p->product_name}}</td>
                        <td>{{$p->price}}</td>
                        <td>{{$p->description}}</td>
                        <td>{{$p->product_rate}}</td>
                        <td>{{$p->stock}}</td>
                        <td>{{$p->weight}}</td>
                        <td>
                            <form action="/adminproduct/{{$p->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-info" onclick="location.href='/adminproduct/{{$p->id}}/edit'">Edit</button>
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