<?php

namespace Igorwanbarros\Autenticacao\Querys;

use Igorwanbarros\Autenticacao\Models\Permissao;
use Illuminate\Support\Facades\DB;

class PermissoesAcls
{
    protected $acls;

    protected $existentes;


    public function __construct()
    {
        $this->acls = acls();
        DB::setFetchMode(\PDO::FETCH_ASSOC);
        $this->existentes = DB::table('autenticacao_permissoes')->get();
        $this->existentes = array_column($this->existentes, 'id', 'slug');
    }


    public function atualizarPermissoes()
    {
        $contador = [
            'adicionados' => 0,
            'atualizados' => 0,
        ];

        foreach ($this->acls as $acl) {
            if (!array_key_exists('slug', $acl)) {
                continue;
            }

            if (array_key_exists($acl['slug'], $this->existentes)) {
                $acl['id'] = $this->existentes[$acl['slug']];
            }

            $permissao = new Permissao();
            $permissao->saveOrUpdate($acl);

            isset($acl['id'])
                ? ++$contador['atualizados']
                : ++$contador['adicionados'];
        }

        return $contador;
    }


    public function getExistentes()
    {
        return $this->existentes;
    }

}