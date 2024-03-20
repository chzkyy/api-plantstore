<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientCredentialsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SavedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
/----------------------------------------------------------------------------
/ Authentication
/----------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::get('clientCredentials', [ClientCredentialsController::class, 'createCCredentials']);
    // create for csrf token
    Route::get('sanctum/csrf-cookie', function (Request $request) {
        return response()->json(
            [
                'code' => 200,
                'status' => 'success',
                'token' => $request->session()->token(), // 'token' => $request->session()->token(),
            ]
        );
    });
});




/**
 *
 * API for User
 *
 */

// product
Route::group(['prefix' => 'product'], function () {
    Route::get('/data', [ProductController::class, 'getProduct']);
    Route::post('/detail', [ProductController::class, 'detailProduct']);
});

// cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/data', [CartController::class, 'dataCart']);
    Route::post('/add', [CartController::class, 'addCart']);
    Route::post('/delete', [CartController::class, 'deleteCart']);
    Route::post('/quantityUpdate', [CartController::class, 'updateQty']);
});

// wishlist
Route::group(['prefix' => 'wishlist'], function () {
    Route::get('/data', [SavedController::class, 'getSaved']);
    Route::post('/add', [SavedController::class, 'addSaved']);
    Route::post('/delete', [SavedController::class, 'deleteSaved']);
});

// orders
Route::group(['prefix' => 'order'], function () {
    Route::get('/history', [OrderController::class, 'getOrder']);
    Route::post('/add', [OrderController::class, 'addOrder']);

});
