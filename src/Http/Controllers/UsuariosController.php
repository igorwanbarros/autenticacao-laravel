<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\Autenticacao\Widgets\FormUser;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\Php2HtmlLaravel\Tabs\TabsViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class UsuariosController extends BaseController
{
    public $tabsTitle = [
        'cadastro'  => 'Cadastro',
        'perfis'    => 'Perfis',
    ];


    public function __construct(Request $request, User $model)
    {
        parent::__construct($request, $model);

        $this->form = new FormUser(url('/autenticacao/usuarios/salvar'), User::class);

        $this->headers = [
            'id' => 'Código',
            'name' => 'Nome',
            'email' => 'Email',
        ];

        $this->title = '<i class="fa fa-user"></i> %s Usuário';
        $this->view->urlBase = 'autenticacao/usuarios';
    }


    public function index()
    {
        return IndexHelper::support($this);
    }


    public function form($id = null)
    {
        $this->tabsTitle['perfis'] = [
            'title' => 'Perfis',
            'data-href' => url("autenticacao/usuarios/{$id}/perfis"),
        ];

        return FormHelper::support($this, compact('id'), $this->personalizeForm());
    }


    protected static function personalizeForm()
    {
        return function ($controller) {
            $tabs = new TabsViewLaravel(
                $controller->tabsTitle,
                [
                    'cadastro'  => "{$controller->form}<div class=\"clearfix\"></div>",
                    'perfis'    => '',
                ]
            );
            $controller->view->widget->setBody("<div class=\"nav-tabs-custom\">{$tabs}</div>");
        };
    }


    public function store()
    {
        $this->view->messages = [
            'retype_password.same' => 'O valor do campo não corresponde ao informado no campo Senha.',
            'retype_password.required_with' => 'É obrigatório ao informar o campo Senha.',
            'password.required_with' => 'É obrigatório ao informar o campo Redigitar Senha.',
        ];


        return StoreHelper::support($this, null, function($controller) {
            if (!$controller->request->get('password') && !$controller->request->get('retype_password')) {
                unset($controller->view->customAttributes['password']);
                unset($controller->view->customAttributes['retype_password']);
            }
        });
    }


    public function destroy($id)
    {
        return DestroyHelper::support($this, compact('id'));
    }
}
