<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
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

                $dataDb = Orders::where('user_id', $user_id)->get();

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'data' => $dataDb
                ]);
            }
        }
    }

}
