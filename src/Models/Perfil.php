<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Perfil extends BaseModel
{
    protected $table    = 'autenticacao_perfis';
    

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class, 'autenticacao_perfis_permissoes');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'autenticacao_users_perfis');
    }


    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'autenticacao_users_perfis');
    }

}
