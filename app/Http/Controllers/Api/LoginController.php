<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\ApiTokenService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Models\user_active;
use Illuminate\Support\Facades\Auth;

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
            $user =  User::where('nim', $request->nim)->first(['nim','username','email']);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil login',
                'data' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Gagal Login, Credentials Tidak Valid'
        ],400);
    } 

    public function logout()
    {
        $nim = request()->header('user_active_id');
        user_active::deleteToken($nim);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Logout'
        ],200);
    }

}
