<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $sessionUser = $request->session()->get('currentAdmin', null);
        if ($sessionUser->hasUserHasRole()->first()->belongsToRole()->first()->id == 1) {
            return $next($request);
        }
        return redirect('/not-permission');
    }
}
