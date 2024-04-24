<?php

namespace App\Http\Middleware;

use Closure;

use JWTAuth;

use Exception;
use SebastianBergmann\Environment\Console;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware

{

  /**

   * Handle an incoming request.

   *

   * @param \Illuminate\Http\Request $request

   * @param \Closure $next

   * @return mixed

   */

  public function handle($request, Closure $next)

  {
    try {
      if (!$user = JWTAuth::parseToken()->authenticate()) {
        throw new Exception('User Not Found');
      }
    } catch (Exception $e) {
      if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
        return response()->json(
          [
            'response' => null,
            'statusCode' => 400,
            'message' => 'Token Invalid',
          ]
        );
      } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
        return response()->json(
          [
            'response' => null,
            'statusCode' => 400,
            'message' => 'Token Expired'
          ]
        );
      } else {
        if ($e->getMessage() === 'User Not Found') {
          return response()->json(
            [
              "response" => null,
              "statusCode" => 400,
              "message" => "User Not Found"
            ]
          );
        }
        return response()->json(
          [
            'response' => null,
            'statusCode' => 400,
            'message' => 'Authorization Token not found'
          ]
        );
      }
    }
    return $next($request);
  }
}
