<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth as TymonJWTAuth;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $user = TymonJWTAuth::parseToken()->authenticate()) {
            return response()->json(['error' => 'User not found'],404);
        }
        if (! $user->isAdmin ) {
            return response()->json(['error' => 'User have not permissions'],404);
        }
        
        return $next($request);
    }
}
