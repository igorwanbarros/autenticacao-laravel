<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Permission extends BaseModel
{
    protected $table    = 'autenticacao_permissions';
    

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'autenticacao_roles_permissions');
    }
}