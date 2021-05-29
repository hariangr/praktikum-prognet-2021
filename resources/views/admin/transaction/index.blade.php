@extends('layout')

@section('page-contents')
    @php
    $number = 0;
    @endphp

    <h1>Kelola Transaksi Berlangsung</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Timeout</th>
                <th>Subtotal (Rp)</th>
                <th>Courier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allTrans as $it)
                <tr>
                    <td>{{ $number += 1 }}</td>
                    <td>{{ $it->user->name }}</td>
                    <td>{{ $it->timeout }}</td>
                    <td>Rp. {{ $it->sub_total }}, -</td>
                    <td>{{ $it->courier->courier }}</td>
                    <td>{{ $it->status ?? 'Menunggu pembayaran' }}</td>
                    <td>
                        <a href="{{ route('admin.transaction.show', $it->id) }}">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
