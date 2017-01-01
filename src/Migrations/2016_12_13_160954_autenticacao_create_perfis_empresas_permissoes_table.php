<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreatePerfisEmpresasPermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_perfis_empresas_permissoes', function (Blueprint $tb) {
            $tb->integer('perfil_empresa_id', false, true);
            $tb->foreign('perfil_empresa_id', 'autenticacao_perfil_empresa_id_foreign')->references('id')->on('autenticacao_perfis_empresas');
            $tb->integer('permissao_id', false, true);
            $tb->foreign('permissao_id', 'autenticacao_perfil_permissao_id_foreign')->references('id')->on('autenticacao_permissoes');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_perfis_empresas_permissoes');
    }
}
