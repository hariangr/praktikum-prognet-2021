@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>


                    <a href="{{ route('cart.index') }}">Lihat Keranjang Belanja ({{ count($myCart) }})</a>

                    <div class="card-body">
                        @foreach ($products as $it)
                            <div class="card" style="width: 18rem;">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <div class="card-body">
                                    <h5 class="card-title">{{ $it->product_name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the
                                        bulk of the card's content.</p>
                                    <a href="#" class="btn btn-primary">Buy</a>

                                    <form action="{{ route('cart.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $it->id }}">
                                        <button class="btn btn-outline-primary">Add Cart
                                            @if ($it->my_cart() != null)
                                                ({{ $it->my_cart()->qty }})
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
