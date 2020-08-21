<?php


namespace App;

use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as Model;
class Role extends Model
{
    protected $fillable=['name','guard_name'];

}
