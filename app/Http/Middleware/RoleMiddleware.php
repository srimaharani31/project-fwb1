<?php

namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class RoleMiddleware
    {
        public function handle(Request $request, Closure $next, $role)
        {
            if (!Auth::check()) {
                return redirect('/login'); // Redirect to login if not authenticated
            }

            if (!Auth::user()->hasRole($role)) { // Pastikan model User Anda punya method hasRole()
                abort(403, 'Unauthorized action.'); // Or redirect to a forbidden page
            }

            return $next($request);
        }
    }