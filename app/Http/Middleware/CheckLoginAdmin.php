<?php

namespace App\Http\Middleware;

use Closure, Auth;

class CheckLoginAdmin
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
        $sessionUser = $request->session()->get('currentAdmin', null);
        if ($sessionUser == null) {
            return redirect('/lara-admin');
        }
        return $next($request);
    }
}
