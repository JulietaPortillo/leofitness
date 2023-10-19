<?php

namespace App\Models;

use Trebol\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permissions';

    protected $fillable = [
            'name',
            'display_name',
            'description',
            'group_key',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}