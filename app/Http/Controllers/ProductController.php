<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AccessToken;
use App\Models\Products;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    //constructor
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }

    //get data user
    public function getProduct(Request $request)
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
        }else {

            // chcek expired token
            $expired = $checkAuth->expires_at;

            // jika token expired
            if ($expired < now()) {
                return response()->json([
                    'code' => 401,
                    'status' => 'error',
                    'message' => 'Token Expired'

                ]);
            }else {
                // mengeluarkan data product
                // check data saved
                $user_id = $checkAuth->user_id;

                $dataDb = Products::all();

                $saved  = Save::where('user_id', $user_id)->get();

                // check data saved
                foreach ($dataDb as $key => $value) {
                    $dataDb[$key]['saved'] = false;
                    // xhange format price
                    $dataDb[$key]['product_price'] =  number_format($value->product_price, 0, ',', '.');
                    foreach ($saved as $key2 => $value2) {
                        if ($value->id == $value2->product_id) {
                            $dataDb[$key]['saved'] = true;
                        }
                    }
                }

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $dataDb
                ]);
            }

        }
    }
}
