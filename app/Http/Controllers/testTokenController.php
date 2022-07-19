<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\user_active;
use Illuminate\Http\Request;
use App\Services\ApiTokenService;
use Illuminate\Support\Facades\Auth;

class testTokenController extends Controller
{
    public function index(Request $request)
    {
        $nim =  $request->input('nim');
        $username = $request->input('username');

        if(!$nim || !$username){
            return response()->json([
                'status' => 'error',
                'message' => 'nim dan username harus diisi'
            ], 400);
        }
        $token = new ApiTokenService();
        $token = $token->getToken($nim,$username);
        if(Auth::attempt(['nim' => $nim, 'password' => 'password'])){
            user_active::create([
                'nim' => $nim,
                'api_token' => $token
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'berhasil login'
            ], 200);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Gagal Login'
        ]);
    }

    public function data()
    {
        return response()->json(['status' => 200,'message' => 'hai']);
    }
}
