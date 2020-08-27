<?php

namespace App\Http\Middleware;

use App\Menu;
use App\User;
use Closure;
use Illuminate\Support\Facades\Route;

class MenuPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user->isSuperAdmin()) {
            return $next($request);
        }
        $menuids = $user->permissions()->pluck('menu_id')->toArray();

        $uris = Menu::query()->whereIn('id', $menuids)->pluck('uri')->toArray();

        $routeInformation = get_route_information(Route::current());

        $uri = data_get($routeInformation, 'method') . ':' . data_get($routeInformation, 'uri');

        if (in_array($uri, $uris)) {
            return $next($request);
        }
        abort('403', '无权限');
    }
}
