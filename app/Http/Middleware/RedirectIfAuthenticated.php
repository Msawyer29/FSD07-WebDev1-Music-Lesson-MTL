<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var User $user */
                $user = Auth::guard($guard);

                // to admin dashboard
                if($user->hasRole('admin')) {
                    return redirect(route('admin_dashboard'));
                }

                // to student dashboard
                else if($user->hasRole('student')) {
                    return redirect(route('dashboard'));
                }

                else  {
                    return redirect(route('teacher_dashboard'));
                }

                
            }
        }

        return $next($request);
    }
}