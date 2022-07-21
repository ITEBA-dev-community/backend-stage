<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\ApiTokenService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\user_active;

class LoginController extends Controller
{
    public function __construct(ApiTokenService $TokenService)
    {
        $this->TokenService = $TokenService;
    }
    
    public function login(LoginRequest $request)
    {
        // auth validate going to ApiTokenGuard
        if(Auth::validate(['nim' => $request->nim,'username' => $request->username, 'password' => $request->password])){
            
            $token = $this->TokenService->getActiveToken($request->nim,$request->username);

            return response()->json([
                'status' => 200,
                'message' => 'Berhasil login',
                'token' => $token
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Gagal Login, Credentials Tidak Valid'
        ],400);
    } 

}
