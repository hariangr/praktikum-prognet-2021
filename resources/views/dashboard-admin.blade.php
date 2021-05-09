@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Dashboard</h1>
  <h2>Welcome to Admin Dashboard</h2> 
</div>

@endsection

@section('page-contents')
<h3>Menu</h3>
<a href="/adminproduct">
    <button type="button" class="btn btn-primary">Products</button>
</a>

<a href="/admincourier">
    <button type="button" class="btn btn-primary">Courier</button>
</a>
    
<a href="/adminproductcategories">
    <button type="button" class="btn btn-primary">Product Categories</button>
</a>
    
@endsection