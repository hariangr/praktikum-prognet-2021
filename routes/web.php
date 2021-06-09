<?php

use App\Http\Controllers\Admin\TransactionAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\City;
use App\Models\Product;
use App\Models\Province;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Discount;
use App\Models\Product_categories;
use App\Models\ProductReview;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = Product::all();
    if (Auth::user() != null) {
        $carts = Cart::where('user_id', Auth::user()->id)->where('status', 'notyet')->get();
        $myTrans = Transaction::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        $unread = Auth::user()->unreadNotifications;
    } else {
        $carts = [];
        $myTrans = [];
        $unread = [];
    }
    return view('index', compact('products', 'carts', 'myTrans', 'unread'));
})->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/login', function () {
    return redirect(route('userLoginForm'));
})->name('login');

Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::get('/login/user', [LoginController::class, 'showUserLoginForm'])->name('userLoginForm');
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
Route::get('/register/user', [RegisterController::class, 'showUserRegisterForm']);

Route::post('/login/admin', [LoginController::class, 'adminLogin']);
Route::post('/login/user', [LoginController::class, 'userLogin']);
Route::post('/register/admin', [RegisterController::class, 'createAdmin']);
Route::post('/register/user', [RegisterController::class, 'createUser']);

Route::get('/notification', function () {
    $notifications = Auth::user()->notifications;
    return view('user.notification.index', compact('notifications'));
})->middleware('auth:user')->name('notification.index');

Route::get('/home', function () {
    return redirect(route('dashboard.home'));
})->name('home');
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth:user'])->group(function () {

    Route::get('/', function (Request $request) {
        return redirect(route('welcome'));
        // $products = Product::all();
        // $myCart = Cart::where('user_id', Auth::user()->id)->where('status', 'notyet')->get();
        // return view('home', compact('products', 'myCart'));
    })->name('home');
});


Route::prefix('cart')->name('cart.')->middleware(['auth:user'])->group(function () {
    Route::post('/buy', function (Request $request) {
        $exist = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request['product_id'])
            ->where('status', 'notyet')
            ->first();
        if ($exist != null) {
            // Sudah ada, tambahkan qty
            $exist['qty'] = $exist['qty'] + 1;
            $exist->save();
        } else {
            $cart = Cart::create([
                "user_id" => Auth::user()->id,
                "product_id" => $request['product_id'],
                "qty" => 1,
                "status" => 'notyet',
            ]);
            $cart->save();
        }
        return redirect('/cart/mine');
    })->name('buy');
    Route::get('/mine', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'store'])->name('store');
    Route::post('/reduce', [CartController::class, 'reduce'])->name('reduce');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
});


Route::post('/transaction/uploadpayment', [TransactionController::class, 'addPayment'])->name('addPayment');
Route::post('/transaction/addRating', [TransactionController::class, 'addRating'])->name('addRating');
Route::post('/transaction/cancelTrans', [TransactionController::class, 'cancelTrans'])->name('cancelTrans');
Route::resource('transaction', TransactionController::class)
    ->only('index', 'show')
    ->middleware(['auth:user']);

Route::prefix('ongkir')->name('ongkir.')->group(function () {

    Route::get('/provinces', function () {
        $provinces = Province::all();
        return response()->json($provinces);
    })->name('index');

    Route::get('/citiesbyprovinces', function () {
        $cities = City::all();
        return response()->json($cities);
    })->name('store');

    Route::get('/getprice', function (Request $request) {
        try {
            $cost = RajaOngkir::ongkosKirim([
                'origin'        => 114, // ID kota/kabupaten asal
                'destination'   => $request['destination'], // ID kota/kabupaten tujuan
                'weight'        => $request['weight'], // berat barang dalam gram
                'courier'       => $request['courier'] // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ])->get();

            return response()->json($cost);
        } catch (\Throwable $th) {
            return response([], 400);
        }
    })->name('cekharga');
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (Auth::guard('admin')->check()) {
            return redirect(route('admindashboard'));
        } elseif (Auth::guard('user')->check()) {
            return "You're not an admin, please logout and login as admin";
        } else {
            return redirect('/login/admin');
        }
    })->name('home');

    Route::get('/notification', function () {
        $notifications = Auth::user()->notifications;
        return view('user.notification.index', compact('notifications'));
    })->middleware(['auth:admin']);

    Route::resource('/transaction', 'App\Http\Controllers\Admin\TransactionAdminController')->middleware(['auth:admin']);
});

Route::get('/admindashboard', function () {
    $transactions = Transaction::all();
    $products = Product::all();
    $courier = Courier::all();
    $categories = Product_categories::all();
    $discounts = Discount::all();
    $reviews = ProductReview::all();

    $trans_by_year = Transaction::all()
        ->groupBy(function ($val) {
            return Carbon::parse($val->created_at)->format('y');
        });

    $trans_by_month_year = Transaction::all()
        ->groupBy(function ($val) {
            // return Carbon::parse($val->created_at)->format('m');
            return '20' . Carbon::parse($val->created_at)->format('y') . ' ' . Carbon::parse($val->created_at)->format('m');
        });
    $trans_graph_label = [];
    $trans_graph_count = [];
    foreach ($trans_by_month_year->keys()->sort() as $it) {
        array_push($trans_graph_label, $it);
        array_push($trans_graph_count, count($trans_by_month_year[$it]));
    }

    $trans_by_month_year_success = Transaction::whereIn('status', ['success', 'delivered'])
        ->get()
        ->groupBy(function ($val) {
            // return Carbon::parse($val->created_at)->format('m');
            return '20' . Carbon::parse($val->created_at)->format('y') . ' ' . Carbon::parse($val->created_at)->format('m');
        });
    $trans_graph_label_success = [];
    $trans_graph_count_success = [];
    foreach ($trans_by_month_year_success->keys()->sort() as $it) {
        array_push($trans_graph_label_success, $it);
        array_push($trans_graph_count_success, count($trans_by_month_year_success[$it]));
    }

    $trans_by_month_year_failed = Transaction::whereIn('status', ['expired', 'cancelled'])
        ->get()
        ->groupBy(function ($val) {
            // return Carbon::parse($val->created_at)->format('m');
            return '20' . Carbon::parse($val->created_at)->format('y') . ' ' . Carbon::parse($val->created_at)->format('m');
        });
    $trans_graph_label_failed = [];
    $trans_graph_count_failed = [];
    foreach ($trans_by_month_year_failed->keys()->sort() as $it) {
        array_push($trans_graph_label_failed, $it);
        array_push($trans_graph_count_failed, count($trans_by_month_year_failed[$it]));
    }
    

    $trans_graph_label = json_encode($trans_graph_label);
    $trans_graph_count = json_encode($trans_graph_count);
    $trans_graph_label_success = json_encode($trans_graph_label_success);
    $trans_graph_count_success = json_encode($trans_graph_count_success);
    $trans_graph_label_failed = json_encode($trans_graph_label_failed);
    $trans_graph_count_failed = json_encode($trans_graph_count_failed);

    return view('dashboard-admin', compact('trans_graph_label_success', 'trans_graph_count_success', 'trans_graph_label_failed', 'trans_graph_count_failed', 'trans_graph_label', 'trans_graph_count', 'trans_by_year', 'trans_by_month_year', 'transactions', 'products', 'courier', 'categories', 'discounts', 'reviews'));
})->middleware(['auth:admin'])->name('admindashboard');


Route::get('/review/all', [ProductController::class, 'allReview'])->name('allReview');
Route::get('/review/{reviewid}', [ProductController::class, 'showOneReview'])->name('showOneReview');
Route::post('/review/{reviewid}', [ProductController::class, 'replyReview'])->middleware(['auth:admin'])->name('replyReview');
Route::resource('/adminproduct', 'App\Http\Controllers\ProductController')->middleware(['auth:admin']);

Route::resource('/admincourier', 'App\Http\Controllers\CourierController')->middleware(['auth:admin']);
Route::resource('/adminproductcategories', 'App\Http\Controllers\ProductCategoriesController')->middleware(['auth:admin']);
Route::resource('/admindiscount', 'App\Http\Controllers\DiscountController')->middleware(['auth:admin']);
