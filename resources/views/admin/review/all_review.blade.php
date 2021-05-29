@extends('layout')

@section('page-contents')
    @php
    $number = 0;
    @endphp

    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Rating</th>
                <th>Ulasan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $it)
                <tr>
                    <td>{{ $number += 1 }}</td>
                    <td>{{ $it->product->product_name }}</td>
                    <td>{{ $it->rate}}</td>
                    <td>{{ $it->content }}</td>
                    <td>
                        <a href="{{ route('showOneReview', $it->id) }}">Balas</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
