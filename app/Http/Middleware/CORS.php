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
        header('Access-Control-Allow-Headers: Accept,Content-type, Origin, Authorization, X-Requested-With');
        return $next($request);
    }
}
