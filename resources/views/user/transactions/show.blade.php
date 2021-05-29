@extends('layout')


{{ $transaction }}
{{ $number = 0 }}

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
                    <a href="">+ Qty</a>
                    <a href="">- Qty</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
