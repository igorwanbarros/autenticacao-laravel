<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Illuminate\Http\Request;
use Igorwanbarros\Autenticacao\Models\Role;
use Igorwanbarros\Autenticacao\Widgets\FormPerfil;
use Igorwanbarros\BaseLaravel\Http\Support\FormHelper;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Igorwanbarros\BaseLaravel\Http\Support\StoreHelper;
use Igorwanbarros\BaseLaravel\Http\Support\DestroyHelper;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;

class PerfisController extends BaseController
{

    public function __construct(Request $request, Role $model)
    {
        parent::__construct($request, $model);
        $this->form = new FormPerfil(url('autenticacao/perfis/salvar'), Role::class);
        $this->headers = [
            'id' => 'Código',
            'nome' => 'Nome',
        ];
        $this->title = '<i class="fa fa-users"></i> %s Perfis';
        $this->view->urlBase = 'autenticacao/perfis';
    }


    public function index()
    {
        return IndexHelper::support($this);
    }


    public function form($id = null)
    {
        return FormHelper::support($this, compact('id'));
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