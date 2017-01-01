<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateDashboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_dashboard', function (Blueprint $tb) {
            $tb->increments('id');
            $tb->string('titulo');
            $tb->enum('tamanho', ['GRANDE', 'MEDIO', 'PEQUENO'])->default('MEDIO');
            $tb->string('dashboard_name');
            $tb->integer('user_id', false, true);
            $tb->foreign('user_id')->references('id')->on('autenticacao_users');
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
        Schema::drop('autenticacao_dashboard');
    }
}
