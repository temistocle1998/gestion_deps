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
        return $next($request)
        ->header('Acess-Control-Allow-Origin: *')
        ->header('Acess-Control-Allow-Origin: Content-type, X-Auth-Token, Authorization, Origin');
    }
}
