<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Prognet</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="landing/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="landing/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-5">
            <a class="navbar-brand" href="#!">Marketplace</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="/">Home</a></li>

                    @if (Auth::guard('user')->check())
                        <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">My Cart
                                @if (Auth::user() != null)
                                    ({{ count($carts) }})
                                @endif
                            </a></li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('notification.index') }}">Notifikasi
                                ({{ count($unread) }})</a></li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('transaction.index') }}">Transaksi
                                @if (Auth::user() != null)
                                    ({{ count($myTrans) }})
                                @endif
                            </a></li>
                    @endif

                    @if (Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admindashboard') }}">Dashboard Admin</a>
                        </li>
                    @endif

                    @if (Auth::guard('admin')->check())
                        <form id="logoutForm" style="display: inline;" action="{{ route('logout') }}" method="post">
                            @csrf

                            <li class="nav-item">
                                <a class="nav-link" onclick="document.getElementById('logoutForm').submit();">Logout
                                    Admin
                                </a>
                            </li>

                        </form>
                    @elseif(Auth::guard('user')->check())
                        <form id="logoutForm" style="display: inline;" action="{{ route('logout') }}" method="post">
                            @csrf

                            <li class="nav-item">
                                <a class="nav-link" onclick="document.getElementById('logoutForm').submit();">Logout
                                    User
                                </a>
                            </li>

                        </form>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page Content-->
    <div class="container px-4 px-lg-5">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0"
                    src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">Prognet</h1>
                <p>Sebuah website untuk praktikum Pemrograman Internet</p>
                {{-- <a class="btn btn-primary" href="#!">Loi/</a> --}}
            </div>
        </div>
        <!-- Call to Action-->
        {{-- <div class="card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body">
                <p class="text-white m-0">This call to action card is a great place to showcase some important
                    information or display a clever tagline!</p>
            </div>
        </div> --}}
        <!-- Content Row-->
        <div class="row gx-4 gx-lg-5">
            @foreach ($products as $it)
                <div class="col-md-4 mb-5">
                    <img class="card-img-top" src="/img/{{ $it->getFirstImage()->image_name ?? '' }}" alt="Card image cap">
                    <div class="card min-h-100">
                        <div class="card-body">
                            <h2 class="card-title">{{ $it->product_name }}</h2>
                            <p class="card-text">
                                {{ $it->description }}
                            </p>
                            <p><b>Rp. {{$it->price}}, -</b></p>
                            @if ($it->getOneDiscount() != null)
                                Diskon <i>{{$it->getOneDiscount()->percentage}}%</i>
                            @endif
                        </div>
                        <div class="card-footer">
                            <form method="POST" action="{{ route('cart.buy') }}" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $it->id }}">
                                <button class="btn btn-primary ">Beli</button>
                            </form>

                            <form style="display: inline;" action="{{ route('cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $it->id }}">
                                <button class="btn btn-outline-primary">Add to Cart
                                    @if (Auth::user() != null && $it->my_cart() != null)
                                        ({{ $it->my_cart()->qty }})
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container px-4 px-lg-5">
            <p class="m-0 text-center text-white">Copyright &copy; Prognet 2021</p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
