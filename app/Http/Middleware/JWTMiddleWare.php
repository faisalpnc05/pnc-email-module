<?php

namespace App\Http\Middleware;
use JWTAuth;
use Closure;
use Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class JWTMiddleWare
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

        $request = request();
        // $token = $request->bearerToken();

        //@TODO: fix bug JWT token which always throwning  invalid token.
        // try {

        //     if ( !$user = JWTAuth::parseToken('api')->authenticate() ) {
        //         // return $this->error('user-not-found', 204);
        //         return Response::json(['error'=>'user not found'],401);
        //     }
    
        // } catch (TokenExpiredException $e) {
        //     return Response::json(['error'=>'token-expired'],401);
    
        //     // return $this->error('token-expired', 401);
    
        // } catch (TokenInvalidException $e) {
        //     return Response::json(['error'=>'token-invalid'],401);

        //     // return $this->error('token-invalid', 401);
    
        // } catch (JWTException $e) {
        //     return Response::json(['error'=>'token-absent'],400);
    
        //     // return $this->error('token-absent', 400);
    
        // }



        // $request->has('token');
        // dd(JWTAuth::parseToken());
        // $user = JWTAuth::parseToken('api')->authenticate();
        return $next($request);
    }
}
