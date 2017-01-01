<?php

namespace Igorwanbarros\Autenticacao\Querys;

use Illuminate\Support\Facades\DB;

class Usuarios
{
    public function semPerfis()
    {
        $whereNot = DB::table('autenticacao_users_perfis')->lists('user_id', 'user_id');

        return DB::table('autenticacao_users')->whereNotIn('id', $whereNot);
    }
}