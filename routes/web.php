<?php

use App\Http\Controllers\Api\FillingController;
use App\Models\Filling;
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

Route::get('/', function () {
    $filling = Filling::find(52);
    print_r(FillingController::removeImage($filling->image));
    // return view('welcome');
});
