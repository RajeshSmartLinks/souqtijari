<?php
// DI CODE - Start
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// Newly Added
use Illuminate\Support\Facades\Auth;

class UserDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		if (!Auth::check())
		{
			return redirect()->route('userlogin', app()->getLocale());
		}
        return $next($request);
    }
}
// DI CODE - End