@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Product Categories</h1>
  <h2>Edit Kategori Produk</h2> 
</div>

@endsection


@section('page-contents')
<form action="/adminproductcategories" method="PUT" class="needs-validated">
  @csrf
  @method('PUT')
  <div class="form-group">
    <label for="nama">Nama Kategori Produk:</label>
    <input type="text" class="form-control" id="category_name" placeholder="Masukkan Nama Kategori Produk" name="category_name" value="{{$product_categories->category_name}}" required>
  </div>

  <p><button type="submit" class="btn btn-success">Submit</button></p>
</form> 

<button type="button" class="btn btn-primary" onclick="location.href='/adminproductcategories'">Kembali</button>


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