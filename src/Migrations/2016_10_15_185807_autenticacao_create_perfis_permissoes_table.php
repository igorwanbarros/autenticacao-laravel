<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreatePerfisPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_perfis_permissoes', function (Blueprint $tb) {
            $tb->integer('perfil_id', false, true);
            $tb->foreign('perfil_id')->references('id')->on('autenticacao_perfis');
            $tb->integer('permissao_id', false, true);
            $tb->foreign('permissao_id')->references('id')->on('autenticacao_permissoes');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_perfis_permissoes');
    }
}
