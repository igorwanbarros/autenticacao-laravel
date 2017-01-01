<?php
use Igorwanbarros\Autenticacao\Http\Controllers\HomeDashboardsController;

return [
    [
        'name'      => 'usuarios-sem-perfil',
        'alias'     => 'Usuários Sem Perfis',
        'class'     => HomeDashboardsController::class,
        'method'    => 'usuariosSemPerfis',
    ],
    [
        'name'      => 'usuarios-lastest',
        'alias'     => 'Usuários - Ultimos adicionados',
        'class'     => HomeDashboardsController::class,
        'method'    => 'usuariosUltimosAdicionados',
    ],
    [
        'name'      => 'perfis-nao-utilizados',
        'alias'     => 'Perfis Não Utilizados',
        'class'     => HomeDashboardsController::class,
        'method'    => 'perfisNaoUtilizados',
    ],
];
