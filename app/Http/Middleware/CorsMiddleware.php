<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
	public function handle($request, Closure $next)
	{
		$headers = [
			'Access-Control-Allow-Origin'		=> '*',
			'Access-Control-Allow-Methods'		=> 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
			'Access-Control-Allow-Credentials'	=> 'true',
			'Access-Control-Max-Age'			=> '86400',
			'Access-Control-Allow-Headers'		=> 'Content-Type, Autorization, X-Requested-Width, Application, token'
		];

		if ($request->isMethod('OPTIONS')) {
			return response()->json('{"method":"OPTIONS"}', 200, $headers);
		}

		$allowedDomains = explode(',', env('ALLOWED_DOMAINS'));
		$requestHost = $_SERVER['SERVER_NAME'];

		if (array_search($requestHost, $allowedDomains) === false) {
			return response()->json('Petición no valida', 400, $headers);
		}

		$response = $next($request);
		foreach ($headers as $key => $value) {
			$response->header($key, $value);
		}

		return $response;
	}
}
