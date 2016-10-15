<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_users_roles', function (Blueprint $tb) {
            $tb->integer('user_id', false, true);
            $tb->foreign('user_id')->references('id')->on('autenticacao_users');
            $tb->integer('role_id', false, true);
            $tb->foreign('role_id')->references('id')->on('autenticacao_roles');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_users_roles');
    }
}
