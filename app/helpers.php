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


if (!function_exists('list_to_tree')) {
    /** 将数组转换成 tree结构的数据
     * @param array $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @param int $root
     * @return array
     */
    function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        $tree = array();
        if (is_array($list)) {
            //创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $data) {
                //判断是否存在parent
                $parantId = $data[$pid];
                if ($root == $parantId) {
                    $tree[] = &$list[$key];
                } else {
                    if (isset($refer[$parantId])) {
                        $parent = &$refer[$parantId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}


