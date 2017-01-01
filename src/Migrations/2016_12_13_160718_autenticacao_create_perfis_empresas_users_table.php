<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreatePerfisEmpresasUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_perfis_empresas_users', function (Blueprint $tb) {
            $tb->integer('perfil_empresa_id', false, true);
            $tb->foreign('perfil_empresa_id')->references('id')->on('autenticacao_perfis_empresas');
            $tb->integer('user_id', false, true);
            $tb->foreign('user_id')->references('id')->on('autenticacao_users');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_perfis_empresas_users');
    }
}
