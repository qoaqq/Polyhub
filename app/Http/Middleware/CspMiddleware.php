<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $csp = "default-src 'self'; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://sandbox.vnpayment.vn; ";
        $csp .= "img-src 'self' data: https://sandbox.vnpayment.vn; ";
        $csp .= "script-src 'self' 'unsafe-inline' https://sandbox.vnpayment.vn; ";
        $csp .= "connect-src 'self' https://sandbox.vnpayment.vn;";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}