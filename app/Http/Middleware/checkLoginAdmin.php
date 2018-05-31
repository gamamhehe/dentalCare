<?php

namespace App\Http\Middleware;

use Closure;

class checkLoginAdmin
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
        $sessionUser = $request->session()->get('idAdmin', 'default');
        if ($sessionUser == 'default') {
            return redirect('/');
        }
        return $next($request);
    }
}
