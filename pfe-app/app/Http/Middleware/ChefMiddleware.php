<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChefMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'ENSEIGNANT') {
            abort(403);
        }
    
        $chef = \DB::table('ENSEIGNANT')
            ->where('id_user', Auth::user()->id_user)
            ->where('is_chef', 1)
            ->first();
    
        if (!$chef) {
            abort(403);
        }
    
        return $next($request);
    }
}
