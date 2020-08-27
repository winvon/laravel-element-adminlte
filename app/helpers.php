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


if (!function_exists('has_menu_children')) {
    /**
     * 是否有下级菜单
     * @param $data
     * @param $key
     * @return bool
     */
    function has_menu_children($data, $key)
    {
        $arr = data_get($data, $key);
        if (is_array($arr)) {
            return count(array_filter($arr, function ($val) {
                    return !data_get($val, 'is_ajax');
                })) > 0;
        }
        return false;
    }
}


/**
 * 获取后台菜单
 * @return array
 */
function get_admin_menu($get = true)
{
    $user = \Illuminate\Support\Facades\Auth::user();
    if ($get) {
        $menus = $user->getUserMenu();
    } else {
        $menus = $user->getAdminMenu();
    }
    if (count($menus)) {
        // 获取当前得菜单
        $currentRoute = get_route_information(\Illuminate\Support\Facades\Route::current());
        $uri = $currentRoute['method'] . ":" . $currentRoute['uri'];
        // 匹配当前活动得菜单
        $matches = collect($menus)->filter(function ($item) use ($uri) {
            return $uri == $item['uri'];
        });
        // 设置当前得菜单得上级都是活动菜单
        $menusPk = array_pk($menus);
        $matches->each(function ($item) use (&$menusPk) {
            set_active_by_id($menusPk, $item['id']);
        });
        $menus = array_values($menusPk);
    }
    $tree = list_to_tree($menus);
    return $tree;
}


if (!function_exists('array_pk')) {
    /**
     * 数组组件化
     * @param $list
     * @param string $pk
     * @return array
     */
    function array_pk($list, $pk = 'id')
    {
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = $list[$key];
        }
        return $refer;
    }
}


/**
 * @param $menusPk
 * @param $id
 */
function set_active_by_id(&$menusPk, $id)
{
    $item = $menusPk[$id];

    if ($menusPk[$id]) {
        $item['active'] = true;
        data_set($menusPk[$id], 'active', true);
        $pid = data_get($item, 'pid');
        if ($pid) {
            set_active_by_id($menusPk, $pid);
        }
    }
}
