<?php
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handler($request, Closure $next)
    {
        $headers = [
            "Access-Control-Allow-Origin" => "*",
            "Access-Control-Allow-Methods" => "POST, GET, OPTIONS, PUT, DELETE",
            "Access-Control-Allow-Credentials" => "true",
            "Access-Control-Allow-MaxAge" => "86400",
            "Access-Control-Allow-Headers" => "Content-Type, Authorization, X-Request-With"
        ];
        if($request->isMethod('OPTIONS'))
        {
            return response()->json('{ "method": "OPTIONS" }', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }
        return $response;
    }
}