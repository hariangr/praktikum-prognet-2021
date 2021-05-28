<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;

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
    return view('welcome');
});

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


Route::get('/home', function () {
    return redirect(route('dashboard.home'));
})->name('home');
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth:user'])->group(function () {
    
    Route::get('/', function (Request $request) {
        return view('home');
    })->name('home');

});


Route::get('/admin', function (Request $request) {
    // return view('admin.panel');
    return redirect(route('admindashboard'));
})->middleware(['auth:admin'])->name('admin_home');

Route::get('/admindashboard', function () {
    return view('dashboard-admin');
})->middleware(['auth:admin'])->name('admindashboard');


Route::resource('/adminproduct','App\Http\Controllers\ProductController')->middleware(['auth:admin']);
Route::resource('/admincourier','App\Http\Controllers\CourierController')->middleware(['auth:admin']);
Route::resource('/adminproductcategories','App\Http\Controllers\ProductCategoriesController')->middleware(['auth:admin']);
Route::resource('/admindiscount','App\Http\Controllers\DiscountController')->middleware(['auth:admin']);