<?php

namespace Igorwanbarros\Autenticacao\Querys;

use Igorwanbarros\Autenticacao\Models\Permissao;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PerfisPermissoes
{

    /**
     * @var Permissao
     */
    protected $model;


    public function __construct()
    {
        $this->model = new Permissao();
    }


    /**
     * @param $perfilId
     *
     * @return Builder
     */
    public function resumoPermissoesPorPerfil($perfilId)
    {
        $permissoesQtd = DB::table('autenticacao_perfis_permissoes')
            ->select(DB::raw('COUNT(permissoes.group)'))
            ->join('autenticacao_permissoes as permissoes', function ($query) {
                $query->on('permissoes.id', '=', 'autenticacao_perfis_permissoes.permissao_id')
                    ->whereNull('permissoes.deleted_at');
            })
            ->where('autenticacao_perfis_permissoes.perfil_id', '=', $perfilId)
            ->whereRaw('permissoes.group = autenticacao_permissoes.group');

        return $this->model
            ->select(
                '*',
                DB::raw("({$permissoesQtd->toSql()}) as qtd_adicionada"),
                DB::raw('COUNT(autenticacao_permissoes.id) as qtd_permissoes')
            )
            ->groupBy('autenticacao_permissoes.group')
            ->mergeBindings($permissoesQtd);
    }
}