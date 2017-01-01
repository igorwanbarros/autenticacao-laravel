<?php

namespace Igorwanbarros\Autenticacao\Models;

use Igorwanbarros\BaseLaravel\Models\BaseModel;

class Permissao extends BaseModel
{
    protected $table    = 'autenticacao_permissoes';

    protected $fillable = [
        'id',
        'slug',
        'title',
        'description',
        'group',
    ];


    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'autenticacao_perfis_permissoes');
    }
}