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
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ], 401);
            } else {
                // mengeluarkan data cart
                $user_id = $checkAuth->tokenable_id;

                $dataDb = Cart::with('products')->where('user_id', $user_id)->get();
                $dataResult = [];
                if($dataDb->isEmpty()){
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Data cart is empty'
                    ]);
                }else{
                    foreach ($dataDb as $key => $value) {
                        $dataResult[$key]['id'] = $value->id;
                        $dataResult[$key]['product_id'] = $value->products->id;
                        $dataResult[$key]['product_name'] = $value->products->product_name;
                        $dataResult[$key]['product_images'] = $value->products->product_images;
                        // create format rupiah
                        $dataResult[$key]['product_price'] = "Rp " . number_format($value->products->product_price, 0, ',', '.');
                        $dataResult[$key]['quantity'] = $value->quantity;
                        $dataResult[$key]['total_price'] = "Rp " . number_format($value->total_price, 0, ',', '.');
                        $dataResult[$key]['product_description'] = $value->products->product_description;
                        $dataResult[$key]['product_category'] = $value->products->product_category;

                    }

                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'data' => $dataResult
                    ]);
                }
            }
        }
    }

    public function addCart(Request $request)
    {
        // create auth with bearer token
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
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ], 401);
            } else {
                // add to cart
                $user_id        = $checkAuth->tokenable_id;
                $product        = Products::where('id', $request->product_id)->first();
                $total_price    = $request->quantity * $product->product_price;

                Cart::create([
                    'user_id'       => $user_id,
                    'product_id'    => $request->product_id,
                    'quantity'      => $request->quantity,
                    'total_price'   => $total_price
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
        if(!$auth){
            return response()->json([
                'code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
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
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ], 401);
            } else {
                // delete cart
                $user_id = $checkAuth->tokenable_id;
                $cart_id = $request->cart_id;

                Cart::where('user_id', $user_id)->where('id', $cart_id)->delete();

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
        if(!$auth){
            return response()->json([
                'code' => 401,
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
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
        } else {
            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ], 401);
            } else {
                // update quantity
                $user_id = $checkAuth->tokenable_id;
                $cart_id = $request->cart_id;
                $cart    = Cart::where('user_id', $user_id)->where('id', $cart_id)->first();
                $product = Products::where('id', $cart->product_id)->first();

                if ($request->quantity <= 0) {
                    return response()->json([
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'Quantity must be greater than 0'
                    ], 400);
                } else {
                    $cart->update([
                        'quantity' => $request->quantity,
                        'total_price' => $request->quantity * $product->product_price
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

}
