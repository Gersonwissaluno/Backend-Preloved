<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ApiAuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [ApiAuthenticationController::class, 'login']);
Route::post('register', [ApiAuthenticationController::class, 'register']);
Route::get('product', [ProductController::class, 'apiIndex']);
Route::get('product/{id}', [ProductController::class, 'showByCategory']);

Route::middleware('jwt.auth')->group(function () {
    Route::post('category', [CategoryController::class, 'apiStore']);
    Route::post('add-product', [ProductController::class, 'apiStore']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
    Route::post('buy-product', [TransactionController::class, 'buyProduct']);
});
