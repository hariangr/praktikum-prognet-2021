@extends('layout')

@section('page-title')
    <div class="jumbotron text-center">
        <h1>Detail Review</h1>
    </div>
@endsection

@section('page-contents')
    {{-- {{ $product }} --}}
    <a class="btn btn-primary" href="/admindashboard">Kembali</a>

    <h2>Produk</h2>
    <div class="form-group">
        <label for="exampleInputPassword1">Nama Produk</label>
        <input type="text" disabled class="form-control" value="{{ $product->product_name }}">
    </div>

    {{-- {{ $review }} --}}
    <h2>Review</h2>
    <div class="form-group">
        <label for="exampleInputPassword1">Isi Review</label>
        <input type="text" disabled class="form-control" value="{{ $review->content }}">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Rating</label>
        <input type="text" disabled class="form-control" value="{{ $review->rate }}">
    </div>

    <h2>Respon Admin</h2>
    <div class="card p-4">
        @foreach ($adminResponse as $it)
            <div class="form-group">
                <label for="exampleInputPassword1">Respon pada {{$it->created_at}}</label>
                <input type="text" disabled class="form-control" value="{{ $it->content }}">
            </div>
        @endforeach
    </div>

    {{-- {{ $adminResponse }} --}}

    <h2 style="margin-top: 1rem; margin-bottom: 1rem;">Buat Balasan Baru</h2>
    @if ($review != null)
        <form action="{{ route('replyReview', $review->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <textarea class="form-control" name="content" placeholder="Tulis respon..." id="content" cols="30" rows="10"></textarea>
            </div>
            <input type="hidden" name="review_id" value="{{ $review->id }}">
            <button style="margin-top: 1rem;" class="btn btn-primary">Response</button>
        </form>
    @else
        <p>Belum ada review</p>
    @endif
@endsection
