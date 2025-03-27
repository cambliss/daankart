<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->hasMany(RoleUser::class, 'target_id', 'id');
    }

    public function hasRole(string $name): bool
    {
        return $this->roles()->whereRelation('role', 'name', $name)->exists();
    }

    public function permissions()
    {
        //cache permissions with admin id and expire time 1 hour return cache if exist
        $cache = Cache::get('permissions_'.$this->id);
        if(!empty($cache) && false){
            return $cache;
        }
        $permissions = $this->roles()->with('role.permissions')->get()
        ->flatMap(function($roleUser){
            $data =  $roleUser->role->permissions->map(function($permission) {
                return $permission->permission->name;
            });
            return $data;
        });
        Cache::put('permissions_'.$this->id, $permissions, 60 * 60);
        return $permissions;
    }

    public function hasPermission($name): bool
    {
        $hasPermission = $this->permissions()->contains("can_access_all");
        $butCantAccess = false;
        if(is_array($name)){
            foreach($name as $item){
                $hasPermission = $hasPermission || $this->permissions()->contains("can_access_".$item);
                $butCantAccess = $butCantAccess || $this->permissions()->contains("cannot_access_".$item);
            }
        } else {
            $hasPermission = $hasPermission || $this->permissions()->contains("can_access_".$name);
            $butCantAccess = $butCantAccess || $this->permissions()->contains("cannot_access_".$name);
        }
        return $hasPermission && !$butCantAccess;
    }


}
