<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::Resource('orders', OrderController::class)->only(['index','store','edit', 'update']);
Route::get('products/index',[ProductController::class,'index'])->name('products.index');
Route::post('/products/addProductOrder/{product}', [ProductController::class, 'addProductOrder'])->name('products.addProductOrder');




