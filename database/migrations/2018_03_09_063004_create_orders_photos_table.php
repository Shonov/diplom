<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_photos', function (Blueprint $table) {
            $table->integer('order_id');
            $table->integer('photo_id');
            $table->primary(array('order_id', 'photo_id'));

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('photo_id')->references('id')->on('photos');
        });

        Schema::table('orders_photos', function (Blueprint $table) {
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_photos');
    }
}
