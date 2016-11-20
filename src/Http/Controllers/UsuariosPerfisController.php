<?php

namespace Igorwanbarros\Autenticacao\Http\Controllers;

use Igorwanbarros\Autenticacao\Models\User;
use Igorwanbarros\BaseLaravel\Http\Controllers\BaseController;
use Igorwanbarros\BaseLaravel\Http\Support\IndexHelper;
use Illuminate\Http\Request;

class UsuariosPerfisController extends BaseController
{
    public function __construct(Request $request, User $model)
    {
        parent::__construct($request, $model);
        //$this->form = new FormUserRole(url('/autenticacao/usuarios/salvar'), User::class);
        //
        //$this->headers = [
        //    'id' => 'Código',
        //    'name' => 'Nome',
        //    'email' => 'Email',
        //];

        $this->title = '<i class="fa fa-user"></i> %s Perfis';
        $this->view->urlBase = 'autenticacao/usuarios';
    }


    public function index($usuarioId)
    {
        return IndexHelper::support($this, compact('usuarioId'));
    }
}