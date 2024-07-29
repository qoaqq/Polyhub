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
        $csp .= "style-src 'self' 'unsafe-inline' https://sandbox.vnpayment.vn https://cdn.tiny.cloud; ";
        $csp .= "img-src 'self' data: https://sandbox.vnpayment.vn https://sp.tinymce.com https://* https://*.tinymce.com http://localhost http://localhost/storage  blob: data:; ";
        $csp .= "script-src 'self' 'unsafe-inline' https://sandbox.vnpayment.vn https://cdn.tiny.cloud; ";
        $csp .= "connect-src 'self' https://sandbox.vnpayment.vn https://cdn.tiny.cloud https://hyperlinking.iad.tiny.cloud;";
        $csp .= "media-src 'self' data: https://cdn.tiny.cloud https://*; ";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
