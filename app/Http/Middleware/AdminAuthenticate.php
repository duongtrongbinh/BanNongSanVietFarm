<?php
namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasAnyRole(Roles::allRoles())) {
            return $next($request);
        }
        abort(404);
    }
}
