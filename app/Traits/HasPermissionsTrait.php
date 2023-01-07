<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{
    //check user role
    // public function hasRole(...$roles)
    // {
    //     foreach ($roles as $role) {
    //         if ($this->roles->contains('slug', $role)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function hasRole($role)
    {
        if ($this->roles->contains('slug', $role)) {
            return true;
        }
        return false;
    }

    // get permissions
    public function getAllPermissions($permission)
    {
        return Permission::whereIn('slug', $permission)->get();
    }

    // check has permissionn
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }


    public function hasPermissionTo($permission)
    {
        $permission = Permission::where('slug', '=', $permission)->firstOrFail();
        return $this->hasPermissionThroughRole($permission)
            || $this->hasPermission($permission);
    }

    //check permission through role
    public function hasPermissionThroughRole($permissions)
    {
        foreach ($permissions->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    //User Permission Relation
    public function permissions()
    {
        return $this->belongsTomany(Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }
    //User Roles Relation
    public function roles()
    {
        return $this->belongsTomany(Role::class, 'users_roles', 'user_id', 'role_id');
    }
}
