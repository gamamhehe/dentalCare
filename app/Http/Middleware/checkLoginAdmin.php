<?php

namespace App\Http\Middleware;

use Closure, Auth;

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
        $sessionUser = $request->session()->get('admin', 'default');
        if ($sessionUser == 'default') {
            return redirect('/lara-admin');
        }
        return $next($request);
    }
}
