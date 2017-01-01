<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Autenticacao\Models\Empresa;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Widgets\FormPerfisEmpresa;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;
use Igorwanbarros\BaseLaravel\Http\Support\IndexPanelAjaxHelper;

class PerfisEmpresaController extends BaseController
{
    public function __construct(Request $request, Empresa $model)
    {
        parent::__construct($request, $model);
        $this->headers = [
            'empresa'   => 'Empresa',
            'nome'      => 'Perfil',
            'actions'   => '',
        ];

        $this->title = '<i class="fa fa-user"></i> %s Perfis';
        $this->view->urlBase = 'empresas';
    }


    public function index($empresaId)
    {
        $empresa = $this->model->findOrNew($empresaId);
        $this->model = $empresa->perfis();

        $this->view->table = TableViewLaravel::source($this->headers, $this->model)
            ->callback(function (RowTableView $row) use($empresa, $empresaId) {
                $data = $row->getData();
                $data->empresa = $empresa->razao_social;
                $data->actions = view(
                    'autenticacao-laravel::perfis-empresas.row-actions',
                    compact('empresaId', 'data')
                );
            });

        $form = FormPerfisEmpresa::source(url("empresas/{$empresaId}/perfis/salvar"))
            ->personalize($empresaId);

        return IndexPanelAjaxHelper::support(
            $this,
            compact('empresaId'),
            function ($controller) use ($form) {
                $controller->view->widget = $form . $controller->view->widget;
            });
    }


    public function store($empresaId)
    {
        $perfilId = $this->request->get('perfil_id', false);

        $this->validate($this->request, ['perfil_id' => 'required']);

        $this->model->find($empresaId)
            ->perfis()
            ->attach(
                $empresaId,
                ['perfil_id' => $perfilId]
            );

        return $this->view->isAjax
            ? response()->json(['status' => true])
            : redirect("{$this->view->urlBase}/editar/{$empresaId}");
    }


    public function destroy($empresaId, $perfilId)
    {
        $json = [
            'status'    => false,
            'message'   => 'Não foi possível concluir a ação. ' .
                'Perfil encontra-se vinculado a um ou mais Usuários!',
        ];
        $perfis = DB::table('autenticacao_perfis_empresas')
            ->join(
                'autenticacao_perfis_empresas_users',
                'autenticacao_perfis_empresas_users.perfil_empresa_id',
                '=',
                'autenticacao_perfis_empresas.id'
            )
            ->where('empresa_id', '=', $empresaId)
            ->where('perfil_id', '=', $perfilId);

        if ($perfis->count() < 1) {
            DB::table('autenticacao_perfis_empresas')
                ->where('empresa_id', '=', $empresaId)
                ->where('perfil_id', '=', $perfilId)
                ->delete();
            $json = ['status' => true];
        }

        return $this->view->isAjax
            ? response()->json($json)
            : redirect("{$this->view->urlBase}/editar/{$empresaId}");
    }


    public function autocomplete(Perfil $perfil, $empresaId)
    {
        $whereNotInt = $this->model->find($empresaId)
            ->perfis()
            ->lists('perfil_id');
        $results = $perfil->whereNotIn('id', $whereNotInt);

        return $this->_returnAutocompleteResults($results->get());
    }
}
