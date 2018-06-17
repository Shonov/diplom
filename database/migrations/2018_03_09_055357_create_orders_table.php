<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("CREATE TYPE period AS ENUM ('В любое время', 'В период', 'Не позднее чем')");

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
//            $table->integer('count_views')->unsigned()->default(0);
            $table->string('address');
            $table->string('coordinates')->nullable();
            $table->boolean('archive')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('budget_scale_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('budget_scale_id')->references('id')->on('budget_scale');
        });

        DB::unprepared('ALTER TABLE orders ADD COLUMN "time_period" period null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        \DB::unprepared('DROP TYPE period');
    }
}
