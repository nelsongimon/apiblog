<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('token_expired', 401);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('token_invalid', 401);
        } catch (JWTException $e) {
            return $this->errorResponse('token_absent', 401);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
        return $next($request);
    }
}
