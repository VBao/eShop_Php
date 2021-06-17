<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        return $next($request);
        $user = \Auth::user();
        if ($user == null) return response()->json(['status' => 'Not login']);
        if ($user->is_admin == 1) return $next($request);
        return response()->json(['status' => 'Only admin can access']);
    }
}
