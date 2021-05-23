@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Discount</h1>
  <h2>List Discount</h2> 
</div>

@endsection

@section('page-contents')
    <p>
        <button type="button" class="btn btn-primary" onclick="location.href='/admindiscount/create'">Tambah Discount</button>
    </p>
    <p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Jumlah Diskon</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($discount as $d)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$d->id_product}}</td>
                        <td>{{$d->percentage}}%</td>
                        <td>{{$d->start}}</td>
                        <td>{{$d->end}}</td>
                        <td>
                            <form action="/admindiscount/{{$d->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-info" onclick="location.href='/admindiscount/{{$d->id}}'">View</button>
                                <button type="button" class="btn btn-info" onclick="location.href='/admindiscount/{{$d->id}}/edit'">Edit</button>
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