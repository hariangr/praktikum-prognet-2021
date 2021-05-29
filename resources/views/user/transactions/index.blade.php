@extends('layout')
@foreach ($waitings as $it)
    <p>{{ $it }}</p>
@endforeach

<h1>Menunggu Pembayaran</h1>
{{ $number = 0 }}
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
        @foreach ($waitings as $it)
            {{ $number += 1 }}
            <tr>
                <td>{{ $number }}</td>
                <td>{{ $it->timeout }}</td>
                <td>Rp. {{ $it->sub_total }}, -</td>
                <td>{{ $it->courier->courier }}</td>
                <td>{{ $it->status }}</td>
                <td>
                    <a href="{{route('transaction.show', $it->id)}}">Detail</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Diproses Penjual</h2>

<h2>Selesai</h2>

<h2>Gagal</h2>
