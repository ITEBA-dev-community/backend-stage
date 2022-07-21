<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\user_active;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->bearerToken()){
            $checkToken = user_active::CheckToken($request->header('Authorization'))->first();
            if($checkToken){
                return response()->json([
                    'status' => 403,
                    'message' => 'Token User Sudah Active Silahkan Logout Terlebih dahulu',
                ], 403);
            }
        }
        
        if($request->nim && $request->username){
            $checkUser = user_active::where('nim', $request->nim)
            ->where('username',$request->username)->first();
            if($checkUser){
                return response()->json([
                    'status' => 403,
                    'message' => 'User Sudah Active Silahkan Logout Terlebih dahulu',
                ], 403);
            }
        }

        return $next($request);
    }
}
