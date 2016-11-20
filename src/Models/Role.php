<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Role extends BaseModel
{
    protected $table    = 'autenticacao_roles';
    

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'autenticacao_roles_permissions');
    }
}