<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Autenticacao\Models\Permissao;
use Igorwanbarros\Autenticacao\Widgets\FormPermissao;
use Igorwanbarros\Autenticacao\Querys\PerfisPermissoes;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;
use Igorwanbarros\BaseLaravel\Http\Support\IndexPanelAjaxHelper;

class PermissoesController extends BaseController
{

    public function __construct(Request $request, Permissao $model)
    {
        parent::__construct($request, $model);

        $this->headers = [
            'id' => 'Código',
            'group' => 'Grupo',
            'title' => 'Titulo',
        ];

        $this->title = '<i class="fa fa-unlock-alt"></i> %s Permissão';
        $this->view->urlBase = 'perfil/permissoes';

        $this->form = new FormPermissao(url($this->view->urlBase . '/salvar'), Permissao::class);
    }


    public function index($perfilId)
    {
        $acls = new PerfisPermissoes();
        $acls = $acls->resumoPermissoesPorPerfil($perfilId)->get();

        $this->form = '';
        $this->view->table = view('autenticacao-laravel::permissoes.index', compact('acls', 'perfilId'));

        return IndexPanelAjaxHelper::support($this, compact('perfilId'));
    }


    public function grupo($perfilId, $group)
    {
        $this->headers = [
            'id'            => '',
            'title'         => 'Título',
            'description'   => 'Descrição',
        ];
        $perfil = Perfil::findOrNew($perfilId);
        $permissoesSelecionadas = $perfil->permissoes;
        $permissoes = $this->model->where('group', '=', urldecode($group));
        $table = new TableViewLaravel($this->headers, $permissoes);
        $form = $this->form->editar($table, $perfilId, $permissoesSelecionadas);

        return view('autenticacao-laravel::permissoes.edit-permissoes', compact('form'));
    }


    public function store($perfilId)
    {
        if (!$this->request->has('permissoes') && !$this->request->has('group')) {
            return response()->json(['status' => false]);
        }

        $group = $this->request->get('group', false);
        if ($group) {
            DB::table('autenticacao_perfis_permissoes')
                ->where('perfil_id', '=', $perfilId)
                ->whereIn('permissao_id', explode(',', $group))
                ->delete();
        }

        if ($permissoes = $this->request->get('permissoes', false)) {
            $insert = [];

            foreach ($permissoes as $permissao) {
                $insert[] = [
                    'permissao_id' => $permissao,
                    'perfil_id' => $perfilId,
                ];
            }


            DB::table('autenticacao_perfis_permissoes')
                ->insert($insert);
        }

        return response()->json(['status' => true]);
    }
}
