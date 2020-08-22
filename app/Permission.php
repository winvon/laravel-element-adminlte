<?php

namespace App;


class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable=['name','menu_id','guard_name','desc'];
}
