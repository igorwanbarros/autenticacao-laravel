<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Empresa extends BaseModel
{
    protected $table = 'autenticacao_empresas';


    public function users()
    {
        return $this->belongsToMany(User::class, 'autenticacao_users_perfis');
    }


    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'autenticacao_users_perfis');
    }

}
