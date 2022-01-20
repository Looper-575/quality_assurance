<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateApi
{
    private $api_token = "3154f2a10b4aecaa9ae8c10468cd8007";
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->api_token !== $this->api_token) {
            $response['status'] = "Failure";
            $response['result'] = "API authentication failed!";
            return response()->json($response);
        }
        return $next($request);
    }
}
