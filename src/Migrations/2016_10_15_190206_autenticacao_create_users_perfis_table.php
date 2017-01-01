<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateUsersPerfisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_users_perfis', function (Blueprint $tb) {
            $tb->integer('user_id', false, true);
            $tb->foreign('user_id')->references('id')->on('autenticacao_users');
            $tb->integer('perfil_id', false, true);
            $tb->foreign('perfil_id')->references('id')->on('autenticacao_perfis');
            $tb->integer('empresa_id', false, true);
            $tb->foreign('empresa_id')->references('id')->on('autenticacao_empresas');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_users_perfis');
    }
}
