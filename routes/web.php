<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FillingController;
use App\Http\Controllers\SiteController;
use App\Models\Filling;
use App\Models\Type;
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

Route::prefix('/cart')->name('cart.')->group(function(){
  Route::get('/index', [CartController::class, 'index'])->name('index');
  Route::post('/add/{filling}', [CartController::class, 'add'])->name('add');
  Route::post('/change-filling/{filling}', [CartController::class, 'changeCandybarFilling'])->name('change-filling');
  Route::post('/remove/{filling}', [CartController::class, 'remove'])->name('remove');
});

Route::get('/test', function(){
  $type = Type::find(1);
  // $type = Type::where('id', 1)->with(['fillings' => fn($query) => $query->limit(5)])->get();
  echo '<pre>';
  // print_r($type->fillings(10)->get());
  print_r(count($type->fillings));
  // foreach($type[0]->fillings as $item){
  //   echo '<pre>';
  //   print_r($item->title);
  // }
});

