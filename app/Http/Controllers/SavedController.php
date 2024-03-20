<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavedController extends Controller
{

    //constructor
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }

    public function getSaved(Request $request)
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
                $user_id    = $checkAuth->tokenable_id;
                $dataDb     = Save::with('products')->where('user_id', $user_id)->get();
                $dataResult = [];

                // dd($dataDb->toArray());
                if ($dataDb != '[]') {
                    foreach ($dataDb as $key => $value) {
                        $dataResult[$key]['id'] = $value->id;
                        $dataResult[$key]['product_id'] = $value->products->id;
                        $dataResult[$key]['product_name'] = $value->products->product_name;
                        $dataResult[$key]['product_images'] = $value->products->product_images;
                        // create format rupiah
                        $dataResult[$key]['product_price'] = "Rp " . number_format($value->products->product_price, 0, ',', '.');
                        $dataResult[$key]['product_description'] = $value->products->product_description;
                        $dataResult[$key]['product_category'] = $value->products->product_category;

                    }

                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'data' => $dataResult
                    ]);
                } else {
                    return response()->json([
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'Data not found'
                    ]);
                }
            }
        }
    }


    public function addSaved(Request $request)
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
                $user_id        = $checkAuth->tokenable_id;
                $product_id     = $request->product_id;
                $checkProduct   = Save::where('user_id', $user_id)->where('product_id', $product_id)->first();

                if ($checkProduct) {
                    return response()->json([
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'Product already saved'
                    ]);
                } else {
                    $data = new Save();
                    $data->user_id = $user_id;
                    $data->product_id = $product_id;
                    $data->save();

                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Product saved'
                    ]);
                }
            }
        }
    }

    public function deleteSaved(Request $request)
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
                $user_id        = $checkAuth->tokenable_id;
                $product_id     = $request->product_id;
                $checkProduct   = Save::where('user_id', $user_id)->where('product_id', $product_id)->first();

                if ($checkProduct) {
                    $checkProduct->delete();
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Product deleted'
                    ]);
                } else {
                    return response()->json([
                        'code' => 400,
                        'status' => 'error',
                        'message' => 'Product not found'
                    ]);
                }
            }
        }
    }




}
