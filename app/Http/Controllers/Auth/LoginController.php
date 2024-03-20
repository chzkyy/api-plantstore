<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\CientCredential;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            $response = [
                'status'            => 'Success',
                'message'           => 'Login Success',
                'data'              => new UserResource($user),
                'token'             => $user->createToken(
                                            'myApp',
                                            ['*'],
                                            Carbon::now()->addDays(7)
                                        )->accessToken->token,
            ];
            return response()->json($response, 200);
        }

        return response()->json([
            'message' => 'Your credential does not match.',
        ], 401);
    }
}
