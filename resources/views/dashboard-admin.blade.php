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
            ({{count($products)}})</button>
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

@endsection
