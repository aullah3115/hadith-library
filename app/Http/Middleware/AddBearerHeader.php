<?php

namespace App\Http\Middleware;

use Closure;

class AddBearerHeader
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

        $token = $request->cookie('token');

        $request->headers->set('Authorization', 'Bearer ' . $token);

        return $next($request);
    }
}
