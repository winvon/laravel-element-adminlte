<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use  HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param null $id
     * @return bool
     */
    public function isSuperAdmin($id = null)
    {
        if ($id) {
            $user = self::query()->findOrFail($id);
        } else {
            $user = $this;
        }
        return data_get($user, 'id') === config('auth.super_admin');
    }


    public function getUserMenu($id=null)
    {
        $menus = $this->getAdminMenu($id);
        return array_filter($menus, function ($val) {
            return Str::startsWith($val['uri'], 'GET|HEAD');
        });
    }

    /**
     * 获取守护者名称
     * @return string
     */
    protected function getAuthGuardName()
    {


        $prefix = Route::current()->getPrefix();

        $prefix = trim($prefix, '/');

        if (empty($prefix)) {
            return 'user';
        }

        return $prefix;
    }

    /**
     * 菜单权限
     * @param null | int $id
     * @param null | string $guard_name
     * @return array
     */
    public function getAdminMenu($id = null, $guard_name = null)
    {
        if (is_null($id)) {
            $id = $this->id;
        }

        if (empty($id)) {
            return [];
        }

        $key = $this->getAdminMenuKey($id);

        if (is_null($guard_name)) {
            $guard_name = $this->getAuthGuardName();
        }


        $tags = ['admin_menu', 'menu', $key];


        return Cache::tags($tags)->get($key, function () use ($key, $tags, $guard_name) {


            $menu_model = $menus = Menu::with([])
                ->where('guard_name', '=', $guard_name)
                ->where('status', '=', 1)
                ->orderBy('sort', 'desc')
                ->orderBy('id', 'desc');

            if ($this->isSuperAdmin()) {
                $menus = $menu_model
                    ->get(['id', 'uri', 'pid', 'name', 'icon', 'is_ajax'])
                    ->toArray();

            } else {
                // 获取菜单权限
                $permission = $this->getAllPermissions()
                    ->where('guard_name', '=', $guard_name)
                    ->map(function ($item) {
                        $name = data_get($item, 'name');
                        return [
                            'id' => data_get($item, 'id'),
                            'name' => intval($name),
                        ];
                    });

                $menus = $menu_model
                    ->whereIn('id', $permission->pluck('name')->unique())
                    ->get(['id', 'uri', 'pid', 'name', 'icon', 'is_ajax'])
                    ->toArray();

            }

            $menus = array_map(function ($val) {
                $val['method'] = Str::before($val['uri'], ':');
                $val['url'] = Str::start(Str::after($val['uri'], ':'), '/');
                return $val;
            }, $menus);

            if (count($menus)) {
                // 保存缓存了的key
                $time = now()->addDay();
                Cache::tags($tags)->put($key, $menus, $time);
            }

            return $menus;
        });

    }


    /**
     * 后台菜单key
     * @param $id
     * @return string
     */
    public function getAdminMenuKey($id)
    {

        $guard_name = $this->getAuthGuardName();

        return "user_{$id}_admin_menu_{$guard_name}";
    }
}
