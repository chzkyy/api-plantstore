<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientCredentialsController;
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
Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);

Route::get('/clientCredentials', [ClientCredentialsController::class, 'createCCredentials']);

// create for csrf token
Route::get('/sanctum/csrf-cookie', function (Request $request) {
    return response()->json(
        [
            'code' => 200,
            'status' => 'success',
            'token' => $request->session()->token(), // 'token' => $request->session()->token(),
        ]
    );
});


/**
 *
 * API for User
 *
 */


Route::get('/getProduct', [ProductController::class, 'getProduct']);

// cart
Route::get('/dataCart', [CartController::class, 'dataCart']);
Route::post('/addCart', [CartController::class, 'addCart']);
Route::post('/deleteCart', [CartController::class, 'deleteCart']);
Route::post('/updateQty', [CartController::class, 'updateQty']);

// saved
Route::get('/getSaved', [SavedController::class, 'getSaved']);
Route::post('/addSaved', [SavedController::class, 'addSaved']);
Route::post('/deleteSaved', [SavedController::class, 'deleteSaved']);


// order
