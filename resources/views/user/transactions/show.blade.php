@extends('layout')


{{ $transaction }}
{{ $number = 0 }}


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
        <p>Nilai perlu dibayar: Rp. {{$transaction->sub_total}}, -</p>
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
                    <input type="hidden" name="idTransaksi" value="{{ $transaction->id }}">
                    <input type="file" class="form-control" placeholder="Upload bukti pembayaran" name="bukti[]" required
                        accept="image/*">

                    <button>Upload</button>
                </form>
            @endif

        @endif
        {!! $transaction->timeout !!}
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

@endsection
