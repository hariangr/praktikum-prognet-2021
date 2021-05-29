@extends('layout')

<div>
    <form action="{{ route('cart.checkout') }}" method="post">
        @csrf

        @foreach ($carts as $it)
            <div>
                {{ $it->product->product_name }} //
                qty: {{ $it->qty }}
            </div>
        @endforeach

        <div>
            <label for="address">
                Alamat
                <input type="text" name="address" id="address" required>
            </label>
        </div>

        <div>
            <label>
                Provinsi
                <select name="province" id="province">
                    <option selected disabled>Pilih Provinsi</option>

                    @foreach ($provinces as $it)
                        <option value="{{ $it->province_id }}">{{ $it->name }}</option>
                    @endforeach
                </select>
            </label>
        </div>


        <div>
            <label>
                Kota
                <select name="cities" id="cities">
                    <option disabled>Pilih Kota</option>
                </select>
            </label>
        </div>


        <div>
            <label>
                Kurir
                <select name="courier" id="courier">
                    @foreach ($courier as $it)
                        <option value="{{ $it->courier }}">{{ $it->courier }}</option>
                    @endforeach
                </select>
            </label>
        </div>


        <div>
            <select name="courier_service" id="courier_service">
                <option disabled>Pilih Pengiriman</option>
            </select>
        </div>

        <div>
            <p>Harga barang: {{ $total }}</p>
            <input type="hidden" name="total" value="{{ $total }}">
            <p>Berat total: {{ $berat_total }}</p>
            <input type="hidden" name="weight" value="{{ $berat_total }}">
        </div>

        <button disabled id="checkoutBtn">Checkout</button>
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
