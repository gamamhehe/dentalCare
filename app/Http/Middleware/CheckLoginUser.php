<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginUser
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
        $sessionUser = $request->session()->get('currentUser', null);
        if ($sessionUser == null) {
            return redirect('/loginUser');
        }
        return $next($request);
    }
}
