<?php

use App\Events\OrderStore;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FillingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteController;
use App\Http\Helpers\Telegram;
use App\Models\Filling;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SiteController::class, 'index']);
Route::get('/filling/{type}', [FillingController::class, 'index'])->name('filling');
Route::post('/add-fillings/{type}', [FillingController::class, 'addFillings'])->name('add-fillings');
Route::post('/add-categories/{type}', [FillingController::class, 'addCategories'])->name('add-categories');

Route::get('/product/{type}', [ProductController::class, 'index'])->name('product');
Route::post('/add-products/{type}', [ProductController::class, 'addProducts'])->name('add-products');

Route::get('/order', [OrderController::class, 'index'])->middleware('order.cart.empty')->name('order.index');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

Route::prefix('/cart')->name('cart.')->group(function(){
  Route::get('/index', [CartController::class, 'index'])->name('index');
  Route::post('/add/{filling}', [CartController::class, 'add'])->name('add');
  Route::post('/change-filling/{filling}', [CartController::class, 'changeCandybarFilling'])->name('change-filling');
  Route::post('/remove/{filling}', [CartController::class, 'remove'])->name('remove');
});

Route::get('/test', function(Telegram $telegram){
  // $order = Order::find(7);
  // $orderItemsTemp = $order->orderItems()->get()->toArray();
  //           $orderItems = Arr::pluck($orderItemsTemp, 'filling_id');
  //           $fillings = Filling::whereIn('id', $orderItems)->get()->toArray();
  //           $fillings = Arr::keyBy($fillings, 'id');
  // OrderStore::dispatch($order);
  // echo '<pre>';
  // $a = $orderItemsTemp[2]['weight'];
  // var_dump($orderItemsTemp);
  // print_r('asd');
  // Telegram::sendMessage('asdadads');
});

