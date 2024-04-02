    <?php

    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\ClientCredentialsController;
    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\SavedController;
use App\Http\Controllers\UserController;
use App\Models\AccessToken;
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

        // create logout
        Route::post('logout', function (Request $request) {
            $auth = $request->header('Authorization');
            if(!$auth){
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }
            $auth = explode(' ', $auth);
            $auth = $auth[1];

            // check token
            $checkAuth = AccessToken::where('token', $auth)->first();

            // jika token tidak ada
            if (!$checkAuth) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 401);
            }else {
                // chcek expired token
                $expired = $checkAuth->expires_at;

                // jika token expired
                if ($expired < now()) {
                    return response()->json([
                        'code' => 401,
                        'status' => 'error',
                        'message' => 'Token Expired'
                    ], 401);
                }
            }

            $checkAuth->delete();

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Logout Success',
                ]
            );
        });

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

    Route::group(['prefix' => 'user'], function () {
        Route::get('/data', [UserController::class, 'getUser']);
    });
