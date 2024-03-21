<?php

namespace App\Http\Controllers;

use App\Models\CientCredential;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientCredentialsController extends Controller
{
    //create client credentials
    public function createCCredentials(Request $request)
    {
        // add authorization
        //ambil password dari env
        $password = env('PLANTSTORE_PASSWORD');
        $auth = base64_encode('PlantStore:'. sha1($password));

        // create body dari request privy
        $body = [
            $request->all()
        ];

        // ambil authorization dari header
        $AuthHeader = $request->header('Authorization');
        if (!$AuthHeader) {
            $response = [
                'status' => 'Failed',
                'message' => 'Unauthorized Access',
            ];

            return response()->json($response, 401);
        }

        // ambil base64 dari signature
        $AuthHeader = explode(' ', $AuthHeader);
        $AuthHeader = $AuthHeader[1];

        // cek signature
        if($auth != $AuthHeader){
            $response = [
                'status' => 'Failed',
                'message' => 'Unauthorized Access',
            ];

            return response()->json($response, 401);
        }

        DB::beginTransaction();
        try {
            // check signature
            if( $auth == $AuthHeader ){
                //create client credentials
                $client = CientCredential::insert([
                    'name'          => 'Get Data',
                    'tokenable_type'=> 'App\Models\User',
                    'tokenable_id'  => 1,
                    //create bearer token
                    'token'         => bin2hex(random_bytes(32)),
                    'abilities'     => '["*"]',
                    'last_used_at'  => null,
                    'expires_at'    => now()->addMinutes(60),
                    'created_at'    => now(),
                ]);

                if ($client) {
                    $data   = CientCredential::get()->last();
                    $token  = $data->token;
                    $expire = $data->expires_at;
                    // $token = $token->last();
                    // echo $token;
                    DB::commit();
                    return response()->json([
                        'code' => 200, // 'code' => '200 OK',
                        'status' => 'success',
                        'data' => [
                            //get bearer token
                            'token' => $token,
                            'Token Type' => 'Bearer',
                            'expires_at' => $expire,
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 400, // 'code' => '400 Bad Request',
                        'status' => 'failed',
                        'message' => 'Failed Create Token!',
                        'data' => []
                    ], 400);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500, // 'code' => '500 Internal Server Error',
                'status' => 'failed',
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }
}
