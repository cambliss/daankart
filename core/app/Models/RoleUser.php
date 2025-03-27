<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $guarded = ['id' , 'created_at' , 'updated_at'];

    //Columns: id, target_id, target_type, role_id, created_at, updated_at, deleted_at
    public function target()
    {
        return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
