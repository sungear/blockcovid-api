<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken($token, $data = [])
    {
        return response()->json(array_merge(
            $data,
            [
                'status' => 200,
                'token' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => Auth::factory()->getTTL() * 60
                ]
            ]
        ), 200);
    }
}
