<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutenticacaoCreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autenticacao_roles_permissions', function (Blueprint $tb) {
            $tb->integer('role_id', false, true);
            $tb->foreign('role_id')->references('id')->on('autenticacao_roles');
            $tb->integer('permission_id', false, true);
            $tb->foreign('permission_id')->references('id')->on('autenticacao_permissions');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('autenticacao_roles_permissions');
    }
}
