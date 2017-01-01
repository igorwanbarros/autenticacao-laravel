<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Querys\PerfisUsuarios;
use Igorwanbarros\Autenticacao\Widgets\FormPerfisUsuario;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;
use Igorwanbarros\BaseLaravel\Http\Support\IndexPanelAjaxHelper;

class PerfisUsuariosController extends BaseController
{
    public function __construct(Request $request, Perfil $model)
    {
        parent::__construct($request, $model);
        $this->headers = [
            'razao_social' => 'Empresa',
            'name' => 'Usuário',
            'email' => 'Email',
            'actions' => '',
        ];

        $this->title = '<i class="fa fa-user"></i> %s Usuarios';
        $this->view->urlBase = 'autenticacao/perfis/usuarios';
    }


    public function index($perfilId)
    {
        $this->model = (new PerfisUsuarios())->get($perfilId)
            ->withEmpresa($perfilId)
            ->withUsers($perfilId)
            ->getResult()
            ->addSelect(DB::raw('"" as actions'));

        $form = FormPerfisUsuario::source(url("perfis/{$perfilId}/usuarios/salvar"))
            ->personalize($perfilId);

        list($callbackTable, $callbackSupport) = $this->_indexCallbacks($perfilId, $form);

        $this->view->table = TableViewLaravel::source($this->headers, $this->model)
            ->callback($callbackTable);

        return IndexPanelAjaxHelper::support($this, compact('perfilId'), $callbackSupport);
    }


    protected function _indexCallbacks($perfilId, $form)
    {
        $table = function (RowTableView $row) use ($perfilId) {
            $data = $row->getData();
            $data->actions = view(
                'autenticacao-laravel::perfis-usuarios.row-actions',
                compact('perfilId', 'data')
            );
        };

        $controller = function ($controller) use ($form) {
            $controller->view->widget = $form . $controller->view->widget;
        };

        return [$table, $controller];
    }


    public function store($perfilId)
    {
        $rules = [
            'perfil_id'     => 'required',
            'user_id'       => 'required',
            'empresa_id'    => 'required',
        ];
        $this->validate($this->request, $rules);

        DB::table('autenticacao_users_perfis')
            ->insert([
                'perfil_id'     => $this->request->get('perfil_id'),
                'user_id'       => $this->request->get('user_id'),
                'empresa_id'    => $this->request->get('empresa_id'),
            ]);

        return $this->view->isAjax
            ? response()->json(['status' => true])
            : redirect("perfis/{$perfilId}/editar");
    }


    public function destroy($perfilId, $empresaId, $userId)
    {

        DB::table('autenticacao_users_perfis')
            ->where(function ($query) use ($perfilId, $empresaId, $userId) {
                $query->where('perfil_id', '=', $perfilId)
                    ->where('empresa_id', '=', $empresaId)
                    ->where('user_id', '=', $userId);
            })
            ->delete();

        return $this->view->isAjax
            ? response()->json(['status' => true])
            : redirect("empresas/editar/{$perfilId}");
    }


    public function autocomplete($perfilId)
    {
        DB::setFetchMode(\PDO::FETCH_ASSOC);
        $all = DB::table('autenticacao_users_perfis')
            ->select(DB::raw('CONCAT("\'", empresa_id, ",", user_id, "\'") as empresa_user'))
            ->where('perfil_id', '=', $perfilId)
            ->get();
        $empresaUser = array_column($all, 'empresa_user');

        $cols = 'autenticacao_empresas.*, autenticacao_empresas.id as empresa_id, ' .
            'autenticacao_users.name, autenticacao_users.email, autenticacao_users.id as id, ' .
            'GROUP_CONCAT(autenticacao_empresas.id, ",", autenticacao_users.id) as empresa_user';

        $query = "SELECT {$cols} FROM autenticacao_users " .
            "JOIN autenticacao_empresas ";

        if (($like = $this->request->get('query'))) {
            $query .= " WHERE name LIKE '%{$like}%'";
        }

        $query .= "GROUP BY autenticacao_empresas.id, autenticacao_users.id";

        if ($empresaUser) {
            $empresaUser = implode(',',$empresaUser);
            $query .= " HAVING empresa_user NOT IN({$empresaUser})";
        }


        $users = DB::select(DB::raw($query));

        return $this->_returnAutocompleteResults($users);
    }
}