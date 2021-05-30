@extends('layout')

@section('page-title')
    <div class="jumbotron text-center">
        <h1>Keranjang Belanja</h1>
    </div>
@endsection

@section('page-contents')
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Diskon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $number = 0;
                @endphp
                @foreach ($carts as $it)
                    <tr>
                        <td>{{ $number += 1 }}</td>
                        <td>{{ $it->product->product_name }}</td>
                        <td>Rp. {{ $it->product->price }}, -</td>
                        <td>{{ $it->qty }}</td>
                        <td>{{ $it->product->getOneDiscount() != null ? $it->product->getOneDiscount()->percentage . '%' : 'Tanpa diskon' }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.reduce') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $it->product->id }}">
                                <button class="btn btn-outline-primary">Qty -</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <form action="{{ route('cart.checkout') }}" method="post">
            @csrf

            <h2>Check Out Produk</h2>
            <div class="form-group">
                <label for="address">
                    Alamat
                </label>
                <input class="form-control" type="text" name="address" id="address" required>
            </div>

            <div class="form-group">
                <label>
                    Provinsi
                </label>
                <select class="form-control" name="province" id="province">
                    <option selected disabled>Pilih Provinsi</option>

                    @foreach ($provinces as $it)
                        <option value="{{ $it->province_id }}">{{ $it->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>
                    Kota
                </label>
                <select class="form-control" name="cities" id="cities">
                    <option disabled>Pilih Kota</option>
                </select>
            </div>


            <div class="form-group">
                <label>
                    Kurir
                </label>
                <select class="form-control" name="courier" id="courier">
                    @foreach ($courier as $it)
                        <option value="{{ $it->courier }}">{{ $it->courier }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="">Layanan Pengiriman</label>
                <select class="form-control" name="courier_service" id="courier_service">
                    <option disabled>Pilih Pengiriman</option>
                </select>
            </div>

            <h2>Detail Belanja</h2>
            <div class="form-group">
                <p>Harga barang: <b>Rp. {{ $total }}, -</b></p>
                <input type="hidden" name="total" value="{{ $total }}">
                <p>Berat total: <b>{{ $berat_total }} gram</b></p>
                <input type="hidden" name="weight" value="{{ $berat_total }}">
            </div>

            <button disabled class="btn btn-primary" id="checkoutBtn">Checkout</button>
        </form>

        <script>
            const allCities = {!! $cities !!}

            const provinceEl = document.getElementById("province");
            const citiesEl = document.getElementById("cities");
            const ongkirEl = document.getElementById("hargaOngkir");
            const courierServiceEl = document.getElementById("courier_service");
            const courierEl = document.getElementById("courier");
            const checkoutBtn = document.getElementById("checkoutBtn");

            async function updateOngkir() {
                checkoutBtn.disabled = true;

                const selectedCity = citiesEl.value;
                const courierName = courierEl.value;

                const harga = await axios.get("{{ route('ongkir.cekharga') }}", {
                    params: {
                        "destination": selectedCity,
                        "weight": {{ $berat_total }},
                        "courier": courierName
                    }
                })

                console.log({
                    harga
                });

                if (harga.length == 0) {
                    ongkirEl.innerText = "Tidak tersedia";
                } else {
                    console.log({
                        harga
                    });
                    const firstOne = harga.data[0]

                    document.querySelectorAll(
                        '#courier_service option').forEach(it => it.remove())

                    firstOne.costs.forEach(it => {
                        const txt =
                            `${firstOne.code.toUpperCase()} ${it.service} (Rp ${it.cost[0].value}) dalam ${it.cost[0].etd} hari`;
                        return courierServiceEl.options[courierServiceEl.options.length] = new Option(txt, it
                            .cost[0].value)
                    });
                }

                checkoutBtn.disabled = false;
            }

            courierEl.addEventListener('change', async (e) => {
                updateOngkir();
            })

            provinceEl.addEventListener('change', (e) => {
                const selectedProv = e.target.value;

                document.querySelectorAll(
                    '#cities option').forEach(it => it.remove())

                allCities.forEach(it => {
                    if (it.province_id == selectedProv) {
                        citiesEl.options[citiesEl.options.length] = new Option(it.name, it.city_id)
                    }
                });

                updateOngkir()
            })

            citiesEl.addEventListener('change', async (e) => {
                updateOngkir();
            })

        </script>
    </div>

@endsection
