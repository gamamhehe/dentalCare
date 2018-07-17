<?php

namespace App\Http\Middleware;

use Closure;

class Dentist
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
        $roleId = $sessionUser->hasUserHasRole()->first()->belongsToRole()->first()->id;
        if ($roleId == 2 or $roleId == 1) {
            return $next($request);
        }
        return redirect('/not-permission');
    }
}
