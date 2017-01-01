<?php

/*
 |----------------------------------------------------------------------------
 | Rotas de Autenticacao
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'autenticacao',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/login', [
        //'middleware'    => 'auth:autenticacao_usuario_inicio',
        'as'            => 'login',
        'uses'          => 'AutenticacaoController@index'
    ]);

    $app->get('/perfil-usuario/{userId}', [
        //'middleware'    => 'auth:autenticacao_usuario_inicio',
        'as'            => 'autenticacao.perfil-usuario',
        'uses'          => 'AutenticacaoController@perfis'
    ]);

    $app->get('/perfil-usuario/{userId}/{perfilId}/{empresaId}', [
        //'middleware'    => 'auth:autenticacao_usuario_inicio',
        'uses'          => 'AutenticacaoController@selecionarPerfil'
    ]);

    $app->post('/login', [
        //'middleware'    => 'auth:autenticacao_usuario_inicio',
        'uses'          => 'AutenticacaoController@login'
    ]);

    $app->get('/logout', [
        //'middleware'    => 'auth:autenticacao_usuario_inicio',
        'as'            => 'logout',
        'uses'          => 'AutenticacaoController@logout'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas dos Usuários
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'usuarios',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        'middleware'    => 'auth:autenticacao_usuario_inicio',
        'uses'          => 'UsuariosController@index'
    ]);

    $app->get('/novo', [
        'middleware'    => 'auth:autenticacao_usuario_novo',
        'uses'          => 'UsuariosController@form'
    ]);

    $app->get('/editar/{id}', [
        'middleware'    => 'auth:autenticacao_usuario_editar',
        'uses'          => 'UsuariosController@form'
    ]);

    $app->post('/salvar', [
        'middleware'    => 'auth:autenticacao_usuario_novo+autenticacao_usuario_editar',
        'uses'          => 'UsuariosController@store'
    ]);

    $app->get('/excluir/{id}', [
        'middleware'    => 'auth:autenticacao_usuario_excluir',
        'uses'          => 'UsuariosController@destroy'
    ]);

});

/*
 |----------------------------------------------------------------------------
 | Rotas da Empresa
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'empresas',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        'middleware'    => 'auth:autenticacao_empresas_inicio',
        'uses'          => 'EmpresasController@index'
    ]);

    $app->get('/novo', [
        'middleware'    => 'auth:autenticacao_empresas_novo',
        'uses'          => 'EmpresasController@form'
    ]);

    $app->get('/editar/{id}', [
        'middleware'    => 'auth:autenticacao_empresas_editar',
        'uses'          => 'EmpresasController@form'
    ]);

    $app->post('/salvar', [
        'middleware'    => 'auth:autenticacao_empresas_novo+autenticacao_empresas_editar',
        'uses'          => 'EmpresasController@store'
    ]);

    $app->get('/excluir/{id}', [
        'middleware'    => 'auth:autenticacao_empresas_excluir',
        'uses'          => 'EmpresasController@destroy'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas dos Perfis
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'autenticacao/perfis',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        'middleware'    => 'auth:autenticacao_perfil_inicio',
        'uses'          => 'PerfisController@index'
    ]);

    $app->get('/novo', [
        'middleware'    => 'auth:autenticacao_perfil_novo',
        'uses'          => 'PerfisController@form'
    ]);

    $app->get('/editar/{id}', [
        'middleware'    => 'auth:autenticacao_perfil_editar',
        'uses'          => 'PerfisController@form'
    ]);

    $app->post('/salvar', [
        'middleware'    => 'auth:autenticacao_perfil_novo+autenticacao_perfil_editar',
        'uses'          => 'PerfisController@store'
    ]);

    $app->get('/excluir/{id}', [
        'middleware'    => 'auth:autenticacao_perfil_excluir',
        'uses'          => 'PerfisController@destroy'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas Abas Perfis
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'perfis/{perfilId}/',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    /*
     |-------------------------------------------------------------------------
     | Aba Usuarios
     |-------------------------------------------------------------------------
     */
    $app->get('/usuarios', [
        'middleware'    => 'auth:autenticacao_perfil_usuarios_inicio',
        'uses'          => 'PerfisUsuariosController@index'
    ]);

    $app->post('/usuarios/salvar', [
        'middleware'    => 'auth:autenticacao_perfil_usuarios_novo',
        'uses'          => 'PerfisUsuariosController@store'
    ]);

    $app->get('/usuarios/excluir/{empresaId}/{userId}', [
        'middleware'    => 'auth:autenticacao_perfil_usuarios_excluir',
        'uses'          => 'PerfisUsuariosController@destroy'
    ]);

    $app->post('/usuarios/autocomplete', [
        'middleware'    => 'auth:autenticacao_perfil_usuarios_inicio+autenticacao_perfil_usuarios_novo',
        'uses'          => 'PerfisUsuariosController@autocomplete'
    ]);


    /*
     |-------------------------------------------------------------------------
     | Aba Permissões
     |-------------------------------------------------------------------------
     */
    $app->get('/permissoes', [
        'middleware'    => 'auth:autenticacao_perfil_permissoes_inicio',
        'uses'          => 'PermissoesController@index'
    ]);

    $app->get('/permissoes/grupo/{group}', [
        'middleware'    => 'auth:autenticacao_perfil_permissoes_editar',
        'uses'          => 'PermissoesController@grupo'
    ]);

    $app->post('/permissoes/salvar', [
        'middleware'    => 'auth:autenticacao_perfil_permissoes_editar',
        'uses'          => 'PermissoesController@store'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas Dashboard
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix'    => 'configuracoes/dashboard',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        'middleware'    => 'auth:autenticacao_dashboard_inicio',
        'as'            => 'dashboard',
        'uses'          => 'DashboardController@index'
    ]);

    $app->get('/novo', [
        'middleware'    => 'auth:autenticacao_dashboard_novo',
        'uses'          => 'DashboardContraoller@form'
    ]);

    $app->get('/editar/{id}', [
        'middleware'    => 'auth:autenticacao_dashboard_editar',
        'uses'          => 'DashboardController@form'
    ]);

    $app->post('/salvar', [
        'middleware'    => 'auth:autenticacao_dashboard_novo+autenticacao_dashboard_editar',
        'uses'          => 'DashboardController@store'
    ]);

    $app->get('/visualizar/{id}', [
        'middleware'    => 'auth:autenticacao_dashboard_inicio',
        'uses'          => 'DashboardController@visualizar'
    ]);

    $app->get('/excluir/{id}', [
        'middleware'    => 'auth:autenticacao_dashboard_excluir',
        'uses'          => 'DashboardController@destroy'
    ]);
});

$app->get('/home', [
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers',
    'middleware'    => 'auth',
    'uses'      => 'DashboardController@dashboard'
]);
