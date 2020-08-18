<?php
if (! function_exists('test')) {
    function test()
    {
        echo "test";
    }
}



if (!function_exists('get_route_information_list')) {
    /**
     * 获取所有路由的基本信息
     * @return \Illuminate\Support\Collection
     * @throws
     */
    function get_route_information_list()
    {
        $router = app()->make(\Illuminate\Routing\Router::class);

        return collect($router->getRoutes())->map(function ($route) {
            return get_route_information($route);
        })->filter(function ($routeInfo) {
            return !empty($routeInfo['uri']);
        })->map(function ($routeInfo) {
            $routeInfo['value'] = $routeInfo['method'] . ':' . $routeInfo['uri'];
            return $routeInfo;
        });
    }
}



/**
 * 获取路由信息
 */
if (!function_exists('get_route_information')) {
    function get_route_information(\Illuminate\Routing\Route $route)
    {
        return [
            'domain' => $route->domain(),
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
        ];
    }
}

