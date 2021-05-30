@extends('layout')

@section('tittle', '')

@section('page-title')

    <div class="jumbotron text-center">
        <h1>Admin Dashboard</h1>
        <h2>Welcome to Admin Dashboard</h2>
    </div>

@endsection

@section('page-contents')
    <h3>Menu</h3>
    <a href="/adminproduct">
        <button type="button" class="btn btn-primary">Products
            ({{ count($products) }})</button>
    </a>

    <a href="/admincourier">
        <button type="button" class="btn btn-primary">Courier
            ({{ count($courier) }})</button>
    </a>

    <a href="/adminproductcategories">
        <button type="button" class="btn btn-primary">Product Categories
            ({{ count($categories) }})
        </button>
    </a>

    <a href="/admindiscount">
        <button type="button" class="btn btn-primary">Discount
            ({{ count($discounts) }})
        </button>
    </a>

    <a href="/review/all">
        <button type="button" class="btn btn-primary">All Review
            ({{ count($reviews) }})
        </button>
    </a>

    <a href="/admin/notification">
        <button type="button" class="btn btn-primary">Notifikasi
            ({{ count(Auth::user()->unreadNotifications) }})
        </button>
    </a>

    <a href="/admin/transaction">
        <button type="button" class="btn btn-primary">All Transactions
            ({{ count($transactions) }})
        </button>
    </a>

    <div style="margin-top: 2rem;">
        <h2>Transaksi per Bulan</h2>

        @php
            $number = 0;
        @endphp

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan Tahun</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($trans_by_month_year->keys() as $it)
                    <tr>
                        <td>{{ $number += 1 }}</td>
                        <td>{{ $it }}</td>
                        <td>{{ count($trans_by_month_year[$it]) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        <h2>Transaksi per Tahun</h2>

        @php
            $number = 0;
        @endphp

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($trans_by_year->keys() as $it)
                    <tr>
                        <td>{{ $number += 1 }}</td>
                        <td>20{{ $it }}</td>
                        <td>{{ count($trans_by_year[$it]) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        <h2>Grafik Transaksi</h2>

        <canvas id="myChart" height="100"></canvas>

        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            // const labels = Utils.months({
            //     count: 12
            // });

            const data = {
                labels: {!! $trans_graph_label !!},
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: {!! $trans_graph_count !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            };

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
            });

        </script>
    </div>

@endsection
