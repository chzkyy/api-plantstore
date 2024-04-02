<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    //constructor
    public function __construct()
    {
        // $this->middleware('auth:sanctum');
    }


    public function getUser(Request $request)
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
                $dataDb     = DB::table('users')->where('id', $user_id)->get();

                if($dataDb->isEmpty()){
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'User Not Found',
                    ]);
                }else{
                    $dataResult = [];
                    foreach ($dataDb as $key => $value) {
                        $dataResult[] = [
                            'id' => $value->id,
                            'name' => $value->name,
                            'email' => $value->email,
                        ];
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

}
