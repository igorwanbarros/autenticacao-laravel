<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\Empresa;
use Igorwanbarros\Autenticacao\Widgets\FormEmpresa;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\Php2HtmlLaravel\Tabs\TabsViewLaravel;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class EmpresasController extends BaseController
{
    protected $tabsName = 'empresas';


    public function __construct(Request $request, Empresa $model)
    {
        parent::__construct($request, $model);

        $this->form = new FormEmpresa(url('/empresas/salvar'), Empresa::class);

        $this->headers = [
            'id'                    => 'Código',
            'cnpj'                  => 'CNPJ',
            'razao_social'          => 'Razão Social',
            'nome_fantasia'         => 'Nome Fantasia',
            'telefone_principal'    => 'Telefone',
            'email_principal'       => 'Email',
        ];

        $this->title = '<i class="fa fa-university"></i> %s Empresa';
        $this->view->urlBase = 'empresas';

        $assets = app('assets');
        $assets->addScript(url('assets/autenticacao-laravel/autenticacao.js'));
    }


    public function index()
    {
        return IndexHelper::support($this);
    }


    public function form($id = null)
    {
        $tabs = app('tabs')[$this->tabsName];
        return FormHelper::support($this, compact('id'), $this->personalizeForm($tabs, $id));
    }


    protected static function personalizeForm($tabsEndereco, $id = null)
    {
        return function ($controller) use ($tabsEndereco, $id) {
            $contents['principal'] = "{$controller->form}<div class=\"clearfix\"></div>";
            $tabs = new TabsViewLaravel($tabsEndereco, $contents, $id);
            $controller->view->widget
                ->setBody("<div class=\"nav-tabs-custom\">{$tabs}</div>");
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
