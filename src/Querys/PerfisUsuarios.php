<?php

namespace Igorwanbarros\Autenticacao\Querys;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PerfisUsuarios
{

    /**
     * @var Builder
     */
    protected $result;

    public function __construct()
    {
        $this->result = DB::table('autenticacao_users_perfis');
    }


    /**
     * @param        $id
     * @param string $column
     *
     * @return Builder
     */
    public function get($id, $column = 'perfil_id')
    {
        $this->result
            ->select('autenticacao_perfis.*', 'autenticacao_users_perfis.*')
            ->join('autenticacao_perfis', function ($query) {
                $query->on('autenticacao_perfis.id', '=', 'autenticacao_users_perfis.perfil_id')
                    ->whereNull('autenticacao_perfis.deleted_at');
            })
            ->where($column, '=', $id);

        return $this;
    }


    public function withEmpresa()
    {
       $this->result
            ->addSelect('autenticacao_empresas.*')
            ->join('autenticacao_empresas', function ($query) {
                $query->on('autenticacao_empresas.id', '=', 'autenticacao_users_perfis.empresa_id')
                    ->whereNull('autenticacao_empresas.deleted_at');
            });

        return $this;
    }


    public function withUsers()
    {
        $this->result
            ->addSelect('autenticacao_users.*')
            ->join('autenticacao_users', function ($query) {
                $query->on('autenticacao_users.id', '=', 'autenticacao_users_perfis.user_id')
                    ->whereNull('autenticacao_users.deleted_at');
            });

        return $this;
    }


    public function getResult()
    {
        return $this->result;
    }
}
