<?php
    return [
        'empresa' => [
            'razao_social'          => 'Nome da Empresa',
            'nome_fantasia'         => 'Empresa Fantasia',
            'cnpj'                  => '47422383000150',
            'inscricao_estadual'    => NULL,
            'inscricao_municipal'   => NULL,
            'email_principal'       => NULL,
            'ddd'                   => NULL,
            'telefone_principal'    => NULL,
        ],
        'usuario' => [
            'name'          => 'Administrador',
            'email'         => 'adm@gmail.com',
            'password'      => bcrypt('m1nh@-s3nh@-@qu1'),
        ],
        'perfil' => [
            'nome'  => 'Administrador',
        ],
    ];