<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        $resourceSchool = $request->route('school_name'); 

        if ($resourceSchool && $resourceSchool !== $user->school_name) {
            abort(403, 'Anda tidak memiliki akses ke data sekolah ini.');
        }

        return $next($request);
    }
}
