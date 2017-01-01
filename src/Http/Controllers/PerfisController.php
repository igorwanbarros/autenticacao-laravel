<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\Perfil;
use Igorwanbarros\Php2Html\Table\RowTableView;
use Igorwanbarros\Autenticacao\Widgets\FormPerfil;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\Php2HtmlLaravel\Tabs\TabsViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\Php2HtmlLaravel\Table\TableViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class PerfisController extends BaseController
{
    protected $tabsName = 'perfis';

    public function __construct(Request $request, Perfil $model)
    {
        parent::__construct($request, $model);
        $this->form = new FormPerfil(url('autenticacao/perfis/salvar'), Perfil::class);
        $this->headers = [
            'id'            => 'Código',
            'nome'          => 'Nome',
            'permissoes'    => 'Qtd. Permissões',
            'users'         => 'Qtd. Usuarios',
            'actions'       => '',
        ];
        $this->title = '<i class="fa fa-address-card-o"></i> %s Perfis / Permissões';
        $this->view->urlBase = 'autenticacao/perfis';
        $assets = assets();
        $assets->addStyle(url('assets/autenticacao-laravel/autenticacao.css'));
        $assets->addScript(url('assets/autenticacao-laravel/autenticacao.js'));
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
            $data->users = $data->users ? $data->users->count() : 0;
            $data->permissoes = $data->permissoes ? $data->permissoes->count() : 0;
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
        return StoreHelper::support($this);
    }


    public function destroy($id)
    {
        return DestroyHelper::support($this, compact('id'));
    }
}
