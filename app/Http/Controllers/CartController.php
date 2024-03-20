<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    //constructor
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }


    public function dataCart(Request $request)
    {
        // create auth with bearer token
        $auth = $request->header('Authorization');
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
            ]);
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ]);
            } else {
                // mengeluarkan data cart
                $user_id = $checkAuth->tokenable_id;

                $dataDb = Cart::with('products')->where('user_id', $user_id)->get();

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $dataDb
                ]);
            }
        }
    }

    public function addCart(Request $request)
    {
        // create auth with bearer token
        $auth = $request->header('Authorization');
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
            ]);
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ]);
            } else {
                // add to cart
                $user_id = $checkAuth->tokenable_id;

                $product = Products::where('id', $request->product_id)->first();

                Cart::create([
                    'user_id' => $user_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'total_price' => $request->quantity * $product->price
                ]);

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Add to cart success'
                ]);
            }
        }
    }

    public function deleteCart(Request $request)
    {
        // create auth with bearer token
        $auth = $request->header('Authorization');
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
            ]);
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ]);
            } else {
                // delete cart
                $user_id = $checkAuth->tokenable_id;

                Cart::where('user_id', $user_id)->where('id', $request->id)->delete();

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Delete cart success'
                ]);
            }
        }
    }

    public function updateQty(Request $request)
    {
        // create auth with bearer token
        $auth = $request->header('Authorization');
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
            ]);
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ]);
            } else {
                // update quantity
                $user_id = $checkAuth->tokenable_id;
                $cart    = Cart::where('user_id', $user_id)->where('id', $request->id)->first();

                $product = Products::where('id', $cart->product_id)->first();

                $cart->update([
                    'quantity' => $request->quantity,
                    'total_price' => $request->quantity * $product->price
                ]);

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Update quantity success'
                ]);
            }
        }
    }

}
