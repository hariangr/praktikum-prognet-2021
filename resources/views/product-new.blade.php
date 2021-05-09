@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Products</h1>
  <h2>Tambah Produk</h2> 
</div>

@endsection

@section('page-contents')
<form action="/adminproduct" method="POST" class="needs-validated">
  @csrf
  <div class="form-group">
    <label for="nama">Nama Produk:</label>
    <input type="text" class="form-control" id="product_name" placeholder="Nama Produk" name="product_name" required>
  </div>

  <div class="form-group">
    <label for="nama">Harga Produk:</label>
    <input type="text" class="form-control" id="price" placeholder="Harga Produk" name="price" required>
  </div>
  
  <div class="form-group">
    <label for="nama">Deskripsi Produk:</label>
    <input type="text" class="form-control" id="description" placeholder="Deskripsi Produk" name="description" required>
  </div>

  <div class="form-group">
    <label for="nama">Rate Produk:</label>
    <input type="text" class="form-control" id="product_rate" placeholder="Rate Produk" name="product_rate" required>
  </div>

  <div class="form-group">
    <label for="nama">Stok Produk:</label>
    <input type="text" class="form-control" id="stock" placeholder="Jumlah Stock Produk" name="stock" required>
  </div>

  <div class="form-group">
    <label for="nama">Berat Produk:</label>
    <input type="text" class="form-control" id="weight" placeholder="Berat Produk" name="weight" required>
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk:</label>
    <input type="text" class="form-control" id="image_name" placeholder="Foto Produk" name="image_name" required>
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