<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TeacherAuthenticated
{
   /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() )
        {
            /** @var User $user */
            $user = Auth::user();

            // if user is not admin take him to his dashboard
            if ( $user->hasRole('admin') ) {
                return redirect(route('admin_dashboard'));
            }

            else if ( $user->hasRole('student') ) {
                return redirect(route('student_dashboard'));
            }

            // allow admin to proceed with request
            else if ( $user->hasRole('teacher') ) {
                return $next($request);
            }
        }

        abort(403);  // permission denied error
    }
}