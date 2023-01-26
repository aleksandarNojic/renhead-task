<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasPrivilegeMiddleware
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $privilege)
    {
        if (!$request->user()->hasPrivilege($privilege)) {
            return response()->json([
                'message' => "You do not have permission",
            ], 403);
        }

        return $next($request);
    }
}
