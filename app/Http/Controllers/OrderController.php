<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Models\Cart;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    //constructor
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }


    public function getOrder(Request $request)
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
            }else {
                $user_id    = $checkAuth->tokenable_id;
                $dataDb     = Orders::where('user_id', $user_id)->get();
                $dataResult = [];

                if($dataDb->isEmpty()){
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Data order is empty'
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

    public function addOrder(Request $request)
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
            }else {
                $user_id    = $checkAuth->tokenable_id;
                $cart_id    = $request->cart_id;
                $dataDb     = Cart::where('user_id', $user_id)->where('id', $cart_id)->first();
                
                if($dataDb){
                    $dataDb = $dataDb->toArray();
                    $dataDb['user_id']      = $user_id;
                    $dataDb['product_id']   = $dataDb['product_id'];
                    $dataDb['quantity']     = $dataDb['quantity'];
                    $dataDb['total_price']  = $dataDb['total_price'];
                    $dataDb['status']       = 'delivered';
                    $dataDb['phone']        = $request->phone;
                    $dataDb['address']      = $request->address;
                    $dataDb['created_at']   = now();
                    $dataDb['updated_at']   = now();

                    $insert = Orders::insert($dataDb);
                    if($insert){
                        return response()->json([
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Order success'
                        ]);
                    }else{
                        return response()->json([
                            'code' => 500,
                            'status' => 'error',
                            'message' => 'Order failed'
                        ], 500);
                    }
                }else{
                    return response()->json([
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Data not found'
                    ], 404);
                }
            }
        }
    }
}
