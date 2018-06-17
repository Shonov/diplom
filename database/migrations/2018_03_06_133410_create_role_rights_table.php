<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_rights', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('right_id');
            $table->integer('module_id');
            $table->primary(array('role_id', 'right_id', 'module_id'));
        });

        Schema::table('role_rights', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('right_id')->references('id')->on('rights');
            $table->foreign('module_id')->references('id')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_rights');
    }
}
