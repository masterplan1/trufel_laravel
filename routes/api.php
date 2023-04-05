<?php

use App\Http\Controllers\Api\FillingController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/filling', FillingController::class);
    Route::apiResource('/product', ProductController::class);


    Route::get('/type', [TypeController::class, 'index']);
    Route::get('/get-categories/{type}', [TypeController::class, 'getCategories']);
    Route::get('/get-type-and-categories/{category}', [TypeController::class, 'getTypeByCategoryId']);
});

Route::post('/login', [AuthController::class, 'login']);
