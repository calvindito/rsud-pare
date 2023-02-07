<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Simrs;
use Illuminate\Http\Request;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $prefix = $request->route()->getPrefix();
        $menu = str_replace('/', '.', ltrim($prefix, '/'));

        if (!Simrs::hasPermission($menu)) {
            abort(403);
        }

        return $next($request);
    }
}
