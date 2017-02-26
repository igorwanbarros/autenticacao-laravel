<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Widgets\FormUser;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\Php2HtmlLaravel\Tabs\TabsViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Tags\LabelViewLaravel;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class UsuariosController extends BaseController
{
    protected $tabsName = 'usuarios';


    public function __construct(Request $request, User $model)
    {
        parent::__construct($request, $model);

        $this->form = new FormUser(url('/usuarios/salvar'), User::class);

        $this->headers = [
            'id'        => 'Código',
            'name'      => 'Nome',
            'email'     => 'Email',
            'perfil'    => 'Perfil',
            'actions'   => '',
        ];

        $this->title = '<i class="fa fa-user"></i> %s Usuário';
        $this->view->urlBase = 'usuarios';
    }


    public function index()
    {
        $this->view->table = TableViewLaravel::source($this->headers, $this->model)
            ->callback($this->_indexCallbackTable())
            ->setLineLink(url($this->view->urlBase . '/editar/%s'));

        return IndexHelper::support($this);
    }


    protected function _indexCallbackTable()
    {
        return function (RowTableView $row) {
            $data = $row->getData();
            $label = LabelViewLaravel::source('Sem acesso ao sistema', LabelViewLaravel::BOOTSTRAP_WARNING);

            if (($count = $data->perfis->count()) > 0) {
                $label = '<i class="fa fa-user fa-fw"></i>' . $count . ' Perfis Vinculados';
                $label = LabelViewLaravel::source($label, LabelViewLaravel::BOOTSTRAP_SUCCESS);
            }

            $data->perfil = $label;
            $data->actions = '<a href="' . url($this->view->urlBase . '/excluir/' . $data->id) . '" ' .
                'class="btn btn-xs btn-danger" ' .
                'title="Excluir">' .
                '<i class="fa fa-trash fa-fw"></i>' .
                '<span class="hidden-xs">Excluir</span>' .
                '</a>';
        };
    }


    public function form($id = null)
    {
        $tabs = app('tabs')[$this->tabsName];
        return FormHelper::support($this, compact('id'), $this->personalizeForm($tabs, $id));
    }


    protected static function personalizeForm($tabsUsuario, $id = null)
    {
        return function ($controller) use ($tabsUsuario, $id) {
            $contents['principal'] = "{$controller->form}<div class=\"clearfix\"></div>";
            $tabs = new TabsViewLaravel($tabsUsuario, $contents, $id);
            $controller->view->widget->setBody("<div class=\"nav-tabs-custom\">{$tabs}</div>");
        };
    }


    public function store()
    {
        $this->view->messages = [
            'retype_password.same' => 'O valor do campo não corresponde ao informado no campo Senha.',
            'retype_password.required_with' => 'É obrigatório ao informar o campo Senha.',
            'password.required_with' => 'É obrigatório ao informar o campo Redigitar Senha.',
            'email.unique' => 'O email informado já  encontra-se cadastrado.',
        ];

        $this->form->getField('email')
             ->setRule("unique:autenticacao_users,email,{$this->request->id},id,deleted_at,NULL");

        return StoreHelper::support($this, null, function(UsuariosController $controller) {
            $controller->validarPassword();
        });
    }


    public function validarPassword()
    {
        $dados = $this->request->all();

        if (isset($dados['password']) && $dados['password'] == '') {
            unset($dados['password']);
            unset($dados['retype_password']);
            $this->view->customAttributes = $dados;

            return;
        }

        if (isset($dados['retype_password']) && $dados['password'] == $dados['retype_password']) {
            $dados['password'] = bcrypt($dados['password']);
            $dados['retype_password'] = $dados['password'];
        }

        $this->view->customAttributes = $dados;
    }


    public function destroy($id)
    {
        return DestroyHelper::support($this, compact('id'));
    }

}
