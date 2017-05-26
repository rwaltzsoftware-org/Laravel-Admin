<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Session;

class GeneralMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Session::put('locale','en');
        view()->share('admin_panel_slug',config('app.project.admin_panel_slug'));
        return $next($request);
    }
}
