@extends('layout')

@section('tittle','')

@section('page-title')

<div class="jumbotron text-center">
  <h1>Admin Discount</h1>
  <h2>View Discount</h2> 
</div>

@endsection


@section('page-contents')
<form action="/admindiscount" method="POST" class="needs-validated">
  @csrf

    <div class="form-group">
        <label for="sel1">Nama Produk:</label>
        <select class="form-control" id="id_product" name="id_product" disabled>
            @foreach($product as $p)
            <option value="{{$p->id}}" @if($p->id == $discount->id_product)
                SELECTED
                @endif>{{$p->product_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="nama">Jumlah Persentase Discount:</label>
        <input type="text" class="form-control" id="percentage" value="{{$discount->percentage}}" placeholder="Masukan Jumlah Persentase Discount" name="percentage" readonly>
    </div>

    <label for="start">Tanggal Mulai Diskon:</label>
    <input type="date" id="start" name="start" value="{{$discount->start}}" readonly>

    <label for="start">Tanggal Akhir Diskon:</label>
    <input type="date" id="end" name="end" value="{{$discount->end}}" readonly>

</form> 

<button type="button" class="btn btn-primary" onclick="location.href='/admindiscount'">Kembali</button>


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