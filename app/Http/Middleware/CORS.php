<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
        header('Access-Control-Allow-Origin', '*');
        header('Access-Control-Allow-Methods', "GET,POST,PUT,PATCH,DELETE,OPTIONS");
        header('Access-Control-Allow-Headers: Accept, Origin, Authorization, X-Requested-Withn, NT,X-CustomHeader,Keep-Alive,User-Agent,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range');
        return $next($request);
    }
}
