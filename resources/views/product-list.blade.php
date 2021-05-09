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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </p>
    <button type="button" class="btn btn-primary" onclick="location.href='/admindashboard'">Kembali</button>
    
@endsection