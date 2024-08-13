<?php
namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        $previousUrl = url()->previous();

        if (Auth::check() && Auth::user()->hasAnyRole(Roles::allRoles())) {
            return $next($request);
        }
        if (route('home') == $previousUrl){
            return redirect()->route('404.client');

        }
        else{
              return redirect()->route('404.admin');
        }
    }
}
