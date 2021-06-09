@extends('layout')

@section('page-title')
    <div class="jumbotron text-center">
        <h1>Detail Transaksi</h1>
    </div>
@endsection

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
    </div>

    @if ($transaction->status == null)
        <p id="timerLeft"></p>

        @if ($transaction->proof_of_payment != null)
            <p>Menunggu konfirmasi pembayaran dari admin</p>
            <img src="{{ asset('img/bukti/' . $transaction->proof_of_payment) }}" alt="">
        @else
            @if ($timeNow > $transaction->timeout)
                <p>Waktu pembayaran telah habis</p>
            @else
                <form enctype="multipart/form-data" action="{{ route('addPayment') }}" method="POST">
                    @csrf
                    <input class="form-control" type="hidden" name="idTransaksi" value="{{ $transaction->id }}">
                    <input class="form-control" type="file" class="form-control" placeholder="Upload bukti pembayaran"
                        name="bukti[]" required accept="image/*">

                    <button class="btn btn-primary" style="margin-top: 2rem;">Upload</button>
                </form>
            @endif

        @endif
        <script defer>
            const countdownEl = document.getElementById("timerLeft")
            var countDownDate = moment("{!! $transaction->timeout !!}")
            var timeNow = moment("{!! $timeNow !!}")

            var jsOnOpen = moment()

            var x = setInterval(function() {
                const jsNow = moment()

                const distJs = jsNow - jsOnOpen;

                offsetSinceOpen = timeNow.add(distJs / 1000, 'seconds')
                remaining = countDownDate - offsetSinceOpen;
                // console.log({remaining});

                var seconds = moment.duration(remaining).seconds();
                var minutes = moment.duration(remaining).minutes();
                var hours = Math.trunc(moment.duration(remaining).asHours());
                countdownEl.innerText = `Waktu tersisa ${hours} jam, ${minutes} menit`
            }, 1000);

        </script>

    @else
        <p>Transaksi anda berstatus {{ $transaction->status }}</p>
    @endif


    @if ($transaction->status == null)
        <form action="{{ route('cancelTrans') }}" method="POST">
            @csrf
            <input type="hidden" name="trans_id" value="{{ $transaction->id }}">

            <div style="margin-top: 1rem;">
                <Button class="btn btn-danger">Batalkan Transaksi</Button>
            </div>
        </form>
    @endif

    @if ($transaction->status == 'delivered')
        <form action="{{ route('addRating') }}" method="POST">
            @csrf
            <input type="hidden" name="trans_id" value="{{ $transaction->id }}">

            <div>
                <label for="newRating">
                    Rating
                </label>
                <select class="form-control" name="newRating" id="newRating">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="">
                    Ulasan
                </label>
                <textarea class="form-control" name="content" id="" cols="30" rows="10"></textarea>
            </div>

            <div style="margin-top: 1rem;">
                <Button class="btn btn-primary">Beri Ulasan</Button>
            </div>
        </form>
    @endif

    @if ($transaction->status == 'success')
        <p>Kamu sudah memberikan ulasan</p>
    @endif
@endsection
