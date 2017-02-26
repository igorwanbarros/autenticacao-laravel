<?php

namespace Igorwanbarros\Autenticacao\Commands;

use Igorwanbarros\Autenticacao\Models\Permissao;
use Illuminate\Console\Command;
use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Autenticacao\Models\Empresa;
use Illuminate\Support\Facades\DB;

class RecursosBasicosCommand extends Command
{
    protected $signature = 'autenticacao:resource';

    protected $description = 'Adição de recursos básicos para acesso ao sistema';

    protected $empresa;

    protected $usuario;

    protected $perfil;


    public function handle()
    {
        $line = str_repeat('--~--~-------', 7);
        $this->info("{$line}\nAutenticação - Recursos Básicos\n{$line}");

        $this->criandoModelDefault(Empresa::class, 'empresa', 'cnpj');
        $this->criandoModelDefault(User::class, 'usuario', 'email');
        $this->criandoModelDefault(Perfil::class, 'perfil', 'nome');
        $this->configurandoPermissoes();

        $this->info("Comando executado com sucesso!\n{$line}\n");
    }


    protected function criandoModelDefault($class, $nome, $findAttr)
    {
        $attr = config("autenticacao-resources.{$nome}");
        $model = $class::where($findAttr, '=', $attr[$findAttr]);

        if ($model->count() > 0) {
            $this->{$nome} = $model->first();
            return;
        }

        $model = new $class();
        $model->fillable(array_keys($attr));
        $model->fill($attr)->save();

        $this->{$nome} = $model;
    }


    protected function configurandoPermissoes()
    {
        $this->usuario->perfis()
             ->detach($this->perfil->id, ['empresa_id' => $this->empresa->id]);

        $this->usuario->perfis()
             ->attach($this->perfil->id, ['empresa_id' => $this->empresa->id]);

        DB::setFetchMode(\PDO::FETCH_ASSOC);
        $permissoes = DB::table('autenticacao_permissoes')
            ->select(
                'id as permissao_id'
            )
            ->get();

        $this->perfil->permissoes()
            ->detach();

        $this->perfil->permissoes()
            ->attach($permissoes);
    }
}
