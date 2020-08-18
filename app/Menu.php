<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $fillable = [
        'uri',
        'name',
        'pid',
        'pids',
        'icon',
        'guard_name',
        'status',
        'sort',
        'is_ajax',
    ];

    public $casts=[
        'is_ajax' => 'boolean',
    ];

    /**
     * 新增菜单
     * @param $data
     * @return mixed
     */
    public function addMenu($data)
    {
        $model = self::create($data);

        $parent = null;
        if (data_get($model, 'pid')) {
            $parent = self::query()->find(data_get($model, 'pid'), ['id', 'pids']);
        }
        $model->pids = data_get($parent, 'pids', 0) . "," . $model->id;
        $model->save();
        return $model;
    }
}
