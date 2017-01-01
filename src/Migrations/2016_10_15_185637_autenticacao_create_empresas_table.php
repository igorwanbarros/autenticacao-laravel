<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_empresas', function (Blueprint $tb) {
            $tb->increments('id');
            $tb->string('razao_social')->comment('Razão Social');
            $tb->string('nome_fantasia');
            $tb->string('cnpj', 18)->comment('CNPJ');
            $tb->string('inscricao_estadual', 40)->comment('Inscrição Estadual')->nullable();
            $tb->string('inscricao_municipal', 40)->comment('Inscrição Municipal')->nullable();
            $tb->string('email_principal')->nullable();
            $tb->string('ddd', 5)->comment('DDD')->nullable();
            $tb->string('telefone_principal', 18)->nullable();
            $tb->timestamps();
            $tb->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_empresas');
    }
}
