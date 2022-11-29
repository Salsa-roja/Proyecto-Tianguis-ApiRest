<?php

namespace App\Http\Middleware;

use App\Models\TokenSpec;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('token');

        if (!$token) {
            return response()->json([
                'error' => 'Token not provided.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'El token expiro.'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Ocurrio un error al decodificar el token.',
                'msj' => $e->getMessage()
            ], 401);
        }
        $user = $credentials;

        $request->auth = $user;
        return $next($request);
    }
}
