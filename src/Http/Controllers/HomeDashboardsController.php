<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Igorwanbarros\Autenticacao\Models\Perfil;
use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Querys\Usuarios;
use Igorwanbarros\Php2HtmlLaravel\Tags\LabelViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Panel\PanelViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;

class HomeDashboardsController extends BaseController
{

    public function __construct(Request $request)
    {
        parent::__construct($request, null);
    }


    public function usuariosSemPerfis($titulo = null)
    {
        $perfisPermissoes = new Usuarios();
        $resumo = $perfisPermissoes->semPerfis();
        $headers = [
            'name'      => 'Nome',
            'email'     => 'Email',
            'id'        => '',
        ];
        $table = new TableViewLaravel($headers, $resumo);
        $table->setLineLink(url('autenticacao/perfis'))
              ->callback(function (RowTableView $row) {
                  $data = $row->getData();
                  $data->id = new LabelViewLaravel('Sem acesso ao sistema', LabelViewLaravel::BOOTSTRAP_DANGER);
              });
        $panel = new PanelViewLaravel($titulo ?: 'Usuarios Sem Perfis', $table);
        $panel->setBoxToolsCollapse(true);

        return $panel;
    }


    public function usuariosUltimosAdicionados($titulo = null)
    {
        $users = User::limit(3)->orderBy('created_at', 'desc');
        $headers = [
            'name' => 'Nome',
            'adicionado' => 'Adicionado',
        ];
        $table = new TableViewLaravel($headers, $users);
        $table->setLineLink(url('usuarios/editar/%s'))
            ->callback(function (RowTableView $row) {
                $data = $row->getData();

                $data->adicionado = $data->created_at->format('d/m/Y');
            });

        $panel = new PanelViewLaravel($titulo ?: 'Usuarios Adicionados Recentemente', $table);
        $panel->setBoxToolsCollapse(true);

        return $panel;
    }


    public function perfisNaoUtilizados($titulo = null)
    {
        $whereNot = DB::table('autenticacao_users_perfis')->lists('perfil_id', 'perfil_id');
        $perfis = Perfil::whereNotIn('id', $whereNot);

        $headers = [
            'nome'  => 'Perfil',
            'label' => '',
        ];
        $table = new TableViewLaravel($headers, $perfis);
        $table->setLineLink(url('autenticacao/perfis/%s'))
            ->callback(function (RowTableView $row) {
                $data = $row->getData();
                $data->label = new LabelViewLaravel('Não utilizado', LabelViewLaravel::BOOTSTRAP_DANGER);
            });
        $panel = new PanelViewLaravel($titulo ?: 'Perfis Não Utilizados', $table);
        $panel->setBoxToolsCollapse(true);

        return $panel;
    }
}
