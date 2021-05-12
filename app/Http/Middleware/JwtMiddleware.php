<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        return $next($request);
        try {
            $user=JWTAuth::parseToken()->authenticate();
        }catch (JWTException $ex){
            if ($ex instanceof TokenInvalidException){
                return response()->json(['status'=>'Invalid token']);
            }elseif ($ex instanceof TokenExpiredException){
                return response()->json(['status'=>'Token is expired']);
            }else{
                return response()->json(['status'=>'Token is not found']);
            }
        }
        return next($request);
    }
}
