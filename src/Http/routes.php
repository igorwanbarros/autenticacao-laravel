<?php
/*
 |----------------------------------------------------------------------------
 | Rotas dos Usuários
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix' => 'autenticacao/usuarios',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        //'middleware' => 'auth:autenticacao_usuario_inicio',
        'uses' => 'UsuariosController@index'
    ]);

    $app->get('/novo', [
        //'middleware' => 'auth:autenticacao_usuario_novo',
        'uses' => 'UsuariosController@form'
    ]);

    $app->get('/editar/{id}', [
        //'middleware' => 'auth:autenticacao_usuario_editar',
        'uses' => 'UsuariosController@form'
    ]);

    $app->post('/salvar', [
        //'middleware' => 'auth:autenticacao_usuario_novo|autenticacao_usuario_editar',
        'uses' => 'UsuariosController@store'
    ]);

    $app->get('/excluir/{id}', [
        //'middleware' => 'auth:autenticacao_usuario_excluir',
        'uses' => 'UsuariosController@destroy'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas dos Perfis
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix' => 'autenticacao/perfis',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        //'middleware' => 'auth:autenticacao_perfil_inicio',
        'uses' => 'PerfisController@index'
    ]);

    $app->get('/novo', [
        //'middleware' => 'auth:autenticacao_perfil_novo',
        'uses' => 'PerfisController@form'
    ]);

    $app->get('/editar/{id}', [
        //'middleware' => 'auth:autenticacao_perfil_editar',
        'uses' => 'PerfisController@form'
    ]);

    $app->post('/salvar', [
        //'middleware' => 'auth:autenticacao_perfil_novo|autenticacao_perfil_editar',
        'uses' => 'PerfisController@store'
    ]);

    $app->get('/excluir/{id}', [
        //'middleware' => 'auth:autenticacao_perfil_excluir',
        'uses' => 'PerfisController@destroy'
    ]);

});


/*
 |----------------------------------------------------------------------------
 | Rotas dos Perfis por Usuario
 |----------------------------------------------------------------------------
 */
$app->group([
    'prefix' => 'autenticacao/usuarios/{usuarioId}/perfis',
    'namespace' => 'Igorwanbarros\Autenticacao\Http\Controllers'
], function ($app) {

    $app->get('/', [
        //'middleware' => 'auth:autenticacao_perfil_inicio',
        'uses' => 'UsuariosPerfisController@index'
    ]);

    $app->get('/novo', [
        //'middleware' => 'auth:autenticacao_perfil_novo',
        'uses' => 'UsuariosPerfisController@form'
    ]);

    $app->get('/editar/{id}', [
        //'middleware' => 'auth:autenticacao_perfil_editar',
        'uses' => 'UsuariosPerfisController@form'
    ]);

    $app->post('/salvar', [
        //'middleware' => 'auth:autenticacao_perfil_novo|autenticacao_perfil_editar',
        'uses' => 'UsuariosPerfisController@store'
    ]);

    $app->get('/excluir/{id}', [
        //'middleware' => 'auth:autenticacao_perfil_excluir',
        'uses' => 'UsuariosPerfisController@destroy'
    ]);

});
