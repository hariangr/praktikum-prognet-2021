@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Products</h1>
  <h2>Edit Produk</h2> 
</div>

@endsection

@section('page-contents')

<form action="/adminproduct" method="POST" class="needs-validated" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="nama">Nama Produk:</label>
    <input type="text" class="form-control" id="product_name" placeholder="Masukkan Nama Produk" name="product_name" value="{{$product->product_name}}" required>
  </div>

  <div class="form-group">
    <label for="sel1">Kategori Produk:</label>
    <select class="form-control" id="category_name" name="category_name">
        @foreach($product_categories as $pc)
        <option value="{{$pc->id}}">{{$pc->category_name}}</option>
        @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="nama">Harga Produk:</label>
    <input type="text" class="form-control" id="price"value="{{$product->price}}"  placeholder="Masukkan Harga Produk" name="price" required>
  </div>
  
  <div class="form-group">
    <label for="nama">Deskripsi Produk:</label>
    <input type="text" class="form-control" id="description"value="{{$product->description}}"  placeholder="Masukkan Deskripsi Produk" name="description" required>
  </div>

  <div class="form-group">
    <label for="nama">Rate Produk:</label>
    <input type="text" class="form-control" id="product_rate"value="{{$product->product_rate}}"  placeholder="Masukkan Rate Produk" name="product_rate" required>
  </div>

  <div class="form-group">
    <label for="nama">Stok Produk:</label>
    <input type="text" class="form-control" id="stock"value="{{$product->stock}}"  placeholder="Masukkan Jumlah Stock Produk" name="stock" required>
  </div>

  <div class="form-group">
    <label for="nama">Berat Produk:</label>
    <input type="text" class="form-control" id="weight"value="{{$product->weight}}"  placeholder="Masukkan Berat Produk" name="weight" required>
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk:</label>
    <input type="file" class="form-control" id="image_name" placeholder="Masukkan Foto Produk" name="image_name" required>
  </div>

  <p><button type="submit" class="btn btn-success">Submit</button></p>
</form> 

<button type="button" class="btn btn-primary" onclick="location.href='/adminproduct'">Kembali</button>


<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
    
  }, false);
})();
</script>
    
@endsection