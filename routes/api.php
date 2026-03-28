<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FillingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\AuthController;
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
    Route::apiResource('/category', CategoryController::class);


    Route::get('/type/all', [TypeController::class, 'all']);
    Route::apiResource('/type', TypeController::class);
    Route::get('/get-categories/{type}', [TypeController::class, 'getCategories']);
    Route::get('/get-type-and-categories/{category}', [TypeController::class, 'getTypeByCategoryId']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/order', [OrderController::class, 'index']);
    Route::put('/order/{order}', [OrderController::class, 'update']);
    Route::delete('/order/{order}', [OrderController::class, 'destroy']);
    Route::get('/comment', [CommentController::class, 'index']);
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'login']);
