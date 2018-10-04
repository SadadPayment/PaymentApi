<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class API
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

        if ($request->has('token')) {
            try {
                $jwt = new JWTAuth();
                $this->auth = $jwt->parseToken()->authenticate();
                return $next($request);
            } catch (JWTException $e) {
                $response = array();
                $response += ["error" => true];
                $response += ["message" => "Authentication Error"];
                return response()->json($response,"200");
            }
        }
    }
}
