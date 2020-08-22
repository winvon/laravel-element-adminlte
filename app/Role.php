<?php


namespace App;

use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    protected $fillable = ['name', 'guard_name'];


    /**
     * @param mixed ...$permissions
     * @return Role
     */
    public function syncPermissions1(...$permissions)
    {
        $this->permissions()->detach();

        $old_permissions = $this->permissions()->where('role_id',data_get($this,'id',0))->get();

        $diff = $old_permissions->diff($permissions);

        if ($diff->count()) {
            $this->permissions()->detach($diff);
        }

        $new = $permissions->diff($old_permissions);
        return $this->givePermissionTo($new);
    }
}
