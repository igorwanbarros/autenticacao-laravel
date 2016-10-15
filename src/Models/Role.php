<?php

namespace Igorwanbarros\Autenticacao\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table    = 'autenticacao_roles';
    
    protected $fillable = [
        'nome',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'autenticacao_roles_permissions');
    }
}