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
        if (route('admin.login.form') == $previousUrl){

            return redirect()->route('admin.login.form')->with(['error_role' => 'Bạn chưa được cấp quyền truy cập trang này !']);
        }
        abort(404);
    }
}
