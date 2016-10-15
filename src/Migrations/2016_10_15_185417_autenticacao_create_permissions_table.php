<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_permissions', function (Blueprint $tb) {
            $tb->increments('id');
            $tb->string('nome');
            $tb->string('slug');
            $tb->string('descricao')->nullable();
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
        Schema::drop('autenticacao_permissions');
    }
}
