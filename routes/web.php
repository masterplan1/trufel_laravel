<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FillingController;
use App\Http\Controllers\SiteController;
use App\Models\Filling;
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

Route::prefix('/cart')->name('cart.')->group(function(){
  Route::get('/index', [CartController::class, 'index'])->name('index');
  Route::post('/add/{filling}', [CartController::class, 'add'])->name('add');
  Route::post('/change-filling/{filling}', [CartController::class, 'changeCandybarFilling'])->name('change-filling');
  Route::post('/remove/{filling}', [CartController::class, 'remove'])->name('remove');
});

Route::get('/test', function(){
  $filling = Filling::find(1);
  print_r($filling->type()->weight_quantity);
});

