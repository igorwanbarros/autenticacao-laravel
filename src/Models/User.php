<?php

namespace Igorwanbarros\Autenticacao\Models;

use Illuminate\Auth\Authenticatable;
use Igorwanbarros\BaseLaravel\Models\BaseModel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    protected $table = 'autenticacao_users';


    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'autenticacao_users_perfis');
    }


    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'autenticacao_users_perfis');
    }
}
