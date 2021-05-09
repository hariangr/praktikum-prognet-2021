@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Courier</h1>
  <h2>Tambah Courier</h2> 
</div>

@endsection


@section('page-contents')
<form action="/admincourier" method="POST" class="needs-validated">
  @csrf
  <div class="form-group">
    <label for="nama">Nama Courier:</label>
    <input type="text" class="form-control" id="courier" placeholder="Nama Courier" name="courier" required>
  </div>

  <p><button type="submit" class="btn btn-success">Submit</button></p>
</form> 

<button type="button" class="btn btn-primary" onclick="location.href='/admincourier'">Kembali</button>


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