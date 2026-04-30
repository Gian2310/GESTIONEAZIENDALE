<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role Il ruolo richiesto per accedere (es. 'admin', 'manager', 'employee')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {

            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = $user->role;


        $authorizedRoles = match ($role) {
            'admin' => ['admin'],
            'manager' => ['admin', 'manager'],
            'employee' => ['admin', 'manager', 'employee'],
            default => []
        };


        if (in_array($userRole, $authorizedRoles)) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Accesso non autorizzato. Non disponi dei permessi necessari per questa sezione.');
    }
}
