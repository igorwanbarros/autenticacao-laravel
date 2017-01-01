<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreatePerfisEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_perfis_empresas', function (Blueprint $tb) {
            $tb->increments('id');
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
        Schema::drop('autenticacao_perfis_empresas');
    }
}
