@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Products</h1>
  <h2>Tambah Produk</h2> 
</div>

@endsection

@section('page-contents')
<form action="/adminproduct" method="POST" class="needs-validated" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="nama">Nama Produk:</label>
    <input type="text" class="form-control" id="product_name" placeholder="Masukkan Nama Produk" name="product_name" required>
  </div>

  <div class="form-group">
    <label for="permasalahan_kulit">Kategori Produk:</label>
    @foreach($product_categories as $pc)
      <div class="form-check">
        <label class="form-check-label">
          <input type="checkbox" class="form-check-input" value="{{$pc->id}}" name="category_id[]">{{$pc->category_name}}
        </label>
      </div>
    @endforeach
  </div>

  <div class="form-group">
    <label for="nama">Harga Produk (Rp):</label>
    <input type="number" class="form-control" id="price" placeholder="Masukkan Harga Produk" name="price" required>
  </div>
  
  <div class="form-group">
    <label for="nama">Deskripsi Produk:</label>
    <input type="text" class="form-control" id="description" placeholder="Masukkan Deskripsi Produk" name="description" required>
  </div>

  <div class="form-group">
    <label for="nama">Rate Produk:</label>
    <input type="number" class="form-control" id="product_rate" placeholder="Masukkan Rate Produk" name="product_rate" required>
  </div>

  <div class="form-group">
    <label for="nama">Stok Produk:</label>
    <input type="number" class="form-control" id="stock" placeholder="Masukkan Jumlah Stock Produk" name="stock" required>
  </div>

  <div class="form-group">
    <label for="nama">Berat Produk (Gram):</label>
    <input type="number" class="form-control" id="weight" placeholder="Masukkan Berat Produk" name="weight" required>
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk 1:</label>
    <input type="file" class="form-control" id="image_name1" placeholder="Masukkan Foto Produk" name="image_name1" required>
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk 2:</label>
    <input type="file" class="form-control" id="image_name2" placeholder="Masukkan Foto Produk" name="image_name2">
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk 3:</label>
    <input type="file" class="form-control" id="image_name3" placeholder="Masukkan Foto Produk" name="image_name3">
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk 4:</label>
    <input type="file" class="form-control" id="image_name4" placeholder="Masukkan Foto Produk" name="image_name4">
  </div>

  <div class="form-group">
    <label for="nama">Foto Produk 5:</label>
    <input type="file" class="form-control" id="image_name5" placeholder="Masukkan Foto Produk" name="image_name5">
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