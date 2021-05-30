@extends('layout')

@section('page-title')
    <div class="jumbotron text-center">
        <h1>Detail Transaksi</h1>
    </div>
@endsection


{{-- {{ $transaction }} --}}
@php
    $number = 0;
@endphp


@section('page-contents')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Dikon</th>
                <th>Selling Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->detailTransactions as $it)

                <tr>
                    <td>{{ $number += 1 }}</td>
                    <td>{{ $it->product->product_name }}</td>
                    <td>{{ $it->qty }}</td>
                    <td>{{ $it->discount }}</td>
                    <td>{{ $it->selling_price }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <p>Nilai perlu dibayar: Rp. {{ $transaction->sub_total }}, -</p>
        <p>Status saat ini: {{ $transaction->status }}</p>
        <form action="{{ route('admin.transaction.update', $transaction->id) }}" method="POST">
            {{ method_field('PUT') }}
            @csrf

            <label for="status_update">
                Ubah Status
                <select name="status_update" id="status_update">
                    <option value="unverified" {{ $transaction->status == 'unverified' ? 'selected' : '' }}>unverified
                    </option>
                    <option value="verified" {{ $transaction->status == 'verified' ? 'selected' : '' }}>verified</option>
                    <option value="delivered" {{ $transaction->status == 'delivered' ? 'selected' : '' }}>delivered
                    </option>
                    <option value="success" {{ $transaction->status == 'success' ? 'selected' : '' }}>success</option>
                    <option value="expired" {{ $transaction->status == 'expired' ? 'selected' : '' }}>expired</option>
                    <option value="canceled" {{ $transaction->status == 'canceled' ? 'selected' : '' }}>canceled</option>
                </select>
            </label>

            <div>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
        <div style="padding-top: 2rem;">
            <p>Bukti Transaksi Dikirim</p>
            <img style="max-width: 18rem;" src="{{ asset('img/bukti/' . $transaction->proof_of_payment) }}" alt="">
        </div>
    </div>

@endsection
