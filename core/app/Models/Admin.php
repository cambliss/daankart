<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

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
        $cache = Cache::get('permissions_'.$this->id); // returns collection
        if(!empty($cache) && count($cache) > 0 && $cache->count() > 0){
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
        //if name permission has can_access_admin.fundrise* then $name = "admin.fundrise.all should be true"
        $hasPermission = $this->permissions()->contains("can_access_all");
        $butCantAccess = false;
        $checkPermission = function($name){
            $flag = $this->permissions()->contains("can_access_all");
            if(!$flag) {
                $flag = $this->permissions()->contains(function($permission) use ($name){
                    $permissionName = Str::replaceFirst("can_access_", "", $permission->name);
                    return Str::is($permissionName, $name);
                });
            }
            return $flag;
        };
        if(is_array($name)){
            foreach($name as $item){
                $hasPermission = $hasPermission || $checkPermission("can_access_".$item);
                $butCantAccess = $butCantAccess || $checkPermission("cannot_access_".$item);
            }
        } else {
            $hasPermission = $hasPermission || $checkPermission("can_access_".$name);
            $butCantAccess = $butCantAccess || $checkPermission("cannot_access_".$name);
        }
        return $hasPermission && !$butCantAccess;
    }


}
