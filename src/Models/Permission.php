<?php

namespace Igorwanbarros\Autenticacao\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table    = 'autenticacao_permissions';
    
    protected $fillable = [
        'nome',
        'slug',
        'descricao',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'autenticacao_roles_permissions');
    }
}