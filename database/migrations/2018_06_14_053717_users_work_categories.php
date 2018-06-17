<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersWorkCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_work_categories', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('category_id');
            $table->primary(array('user_id', 'category_id'));
        });

        Schema::table('users_work_categories', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('work_categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_work_categories');
    }
}
