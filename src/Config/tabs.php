<?php
return [
    'usuarios' => [
        'principal' => [
            'title' => 'Principal',
            'id' => 'tabs-principal',
        ],
    ],
    'perfis' => [
        'principal' => [
            'title' => 'Principal',
            'id' => 'tabs-principal',
        ],
        'permissoes' => [
            'title' => 'Permissões',
            'data-href' => url("perfis/%s/permissoes"),
            'id' => 'tabs-permissoes',
            'order' => 2,
        ],
        'usuarios' => [
            'title' => 'Usuários',
            'data-href' => url("perfis/%s/usuarios"),
            'id' => 'tabs-usuarios',
            'order' => 3,
        ],
    ],
    'empresas' => [
        'principal' => [
            'title' => 'Principal',
            'order' => 1,
        ],
    ],
];
