<?php
/*
 |-------------------------------------------------------------------------
 | Configurando Menus da Aplicação - Modulo Autenticação
 |-------------------------------------------------------------------------
 */

use Igorwanbarros\Php2Html\Menu\ItemMenu;

menu()
    /*
     |-------------------------------------------
     | Menu Cadastros
     |-------------------------------------------
     */
    ->addItemMenu('inicio', new ItemMenu('Início', url('/home'), 'fa fa-home'))
    ->createSubNivel(
        'cadastros',
        new ItemMenu('Cadastros', '#', 'fa fa-plus-circle')
    )
    ->addItemSubNivel(
        'cadastros',
        'empresas',
        new ItemMenu(
            'Empresas',
            url('empresas'),
            'fa fa-university'
        )
    )
    ->addItemSubNivel(
        'cadastros',
        'usuarios',
        new ItemMenu(
            'Usuários',
            url('usuarios'),
            'fa fa-user'
        )
    )
    /*
     |-------------------------------------------
     | Menu Configurações
     |-------------------------------------------
     */
    ->createSubNivel(
        'configuracoes',
        new ItemMenu('Configurações', '#', 'fa fa-gears')
    )
    ->addItemSubNivel(
        'configuracoes',
        'dashboard',
        new ItemMenu(
            'Dashboard',
            url('configuracoes/dashboard'),
            'fa fa-tachometer'
        )
    )
    ->addItemSubNivel(
        'configuracoes',
        'acesso',
        new ItemMenu(
            'Perfis/Permissões',
            url('autenticacao/perfis'),
            'fa fa-address-card-o'
        )
    )
    ;