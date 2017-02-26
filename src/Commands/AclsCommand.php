<?php

namespace Igorwanbarros\Autenticacao\Commands;

use Igorwanbarros\Autenticacao\Querys\PermissoesAcls;
use Illuminate\Console\Command;

class AclsCommand extends Command
{
    protected $signature = 'autenticacao:acl';

    protected $description = '';

    protected $acls;


    public function handle()
    {
        $this->acls = new PermissoesAcls();

        $line = str_repeat('--~--~-------', 7);
        $this->info("{$line}\nAutenticação - Acl\n{$line}");
        $contadores = $this->acls->atualizarPermissoes();

        $mensagem = sprintf(
            "\nAdicionados: '%s'; \nAtualizados: '%s';\n",
            $contadores['adicionados'],
            $contadores['atualizados']
        );

        $this->comment($mensagem);
        $this->info("Comando executado com sucesso!\n{$line}\n");
        $this->call('autenticacao:resource');
    }

}
