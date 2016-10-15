<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_users', function (Blueprint $tb) {
            $tb->increments('id');
            $tb->string('name');
            $tb->string('email');
            $tb->string('password', 60);
            $tb->integer('login_count')->default(0);
            $tb->integer('login_attempt')->default(0);
            $tb->rememberToken();
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
        Schema::drop('autenticacao_users');
    }
}
