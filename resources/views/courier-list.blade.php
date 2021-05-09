@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Courier</h1>
  <h2>List Couriers</h2> 
</div>

@endsection

@section('page-contents')
    <p>
        <button type="button" class="btn btn-primary" onclick="location.href='/admincourier/create'">Tambah Courier</button>
    </p>
    <p>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Courier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courier as $c)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$c->courier}}</td>
                        <td>
                            <form action="/admincourier/{{$c->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-info" onclick="location.href='/admincourier/{{$c->id}}/edit'">Edit</button>
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