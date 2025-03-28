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
        // dump($hasPermission,$name);
        $checkPermission = function($name,$prefix = "can_access_"){
            $flag = $this->permissions()->contains($prefix.$name);
            if(!$flag) {
                $flag = $this->permissions()
                ->filter(function ($permission) use ($name, $prefix) {
                    if (!Str::contains($permission, $prefix)) {
                        return false;
                    }

                    $permissionName = Str::replaceFirst($prefix, '', $permission);
                    if(Str::contains($permissionName, "*")) {
                        // dump($permissionName);
                        $permissionName = Str::replaceLast("*", "", $permissionName);
                        return Str::contains($name, $permissionName);
                    }
                    return $permissionName == $name;
                })
                ->isNotEmpty();
                // dd($flag,$name);
            }
            return $flag;
        };
        if(is_array($name)){
            foreach($name as $item){
                $hasPermission = $hasPermission || $checkPermission($item,"can_access_");
                $butCantAccess = $butCantAccess || $checkPermission($item,"cannot_access_");
            }
        } else {
            $hasPermission = $hasPermission || $checkPermission($name,"can_access_");
            $butCantAccess = $butCantAccess || $checkPermission($name,"cannot_access_");
        }
        return $hasPermission && !$butCantAccess;
    }


}
