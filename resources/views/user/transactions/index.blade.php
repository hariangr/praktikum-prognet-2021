@extends('layout')

@section('page-title')
    <div class="jumbotron text-center">
        <h1>Daftar Transaksi</h1>
    </div>
@endsection

@section('page-contents')
    @php
    $number = 0;
    @endphp

    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Timeout</th>
                <th>Subtotal (Rp)</th>
                <th>Courier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myTrans as $it)
                <tr>
                    <td>{{ $number += 1 }}</td>
                    <td>{{ $it->timeout }}</td>
                    <td>Rp. {{ $it->sub_total }}, -</td>
                    <td>{{ $it->courier->courier }}</td>
                    <td>{{ $it->status ?? 'Menunggu pembayaran' }}</td>
                    <td>
                        <a href="{{ route('transaction.show', $it->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
