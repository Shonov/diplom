<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \DB::unprepared("CREATE TYPE gender AS ENUM ('Мужской', 'Женский')");
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('last_name')->nullable();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->boolean('confirmed')->nullable();
            $table->date('birthday')->nullable();
            $table->string('description')->nullable();
            $table->string('city')->nullable();
            $table->string('public_offer')->nullable();
//            $table->addColumn('gender_type','gender');
//            $table->date('birthday')->nullable();
//            $table->string('photo')->nullable();
//            $table->boolean('identity_confirmation');
//            $table->smallInteger('experience')->nullable();
//            $table->boolean('car_availability')->nullable();
//            $table->addColumn( 'guarantee_type','guarantee');
//            $table->boolean('works_under_contract')->nullable();
//            $table->addColumn('work_type', 'work');
//            $table->string('description')->nullable();
//            $table->integer('min_order_amount')->nullable();
//            $table->string('criminal_record')->nullable();
//            $table->boolean('confirmed');
//            $table->decimal('rating', 1, 2)->nullable()->default(0);
//            $table->addColumn('gender_type','gender');
//            $table->date('birthday')->nullable();
//            $table->string('photo')->nullable();
//            $table->boolean('identity_confirmation');
//            $table->smallInteger('experience')->nullable();
//            $table->boolean('car_availability')->nullable();
//            $table->addColumn( 'guarantee_type','guarantee');
//            $table->boolean('works_under_contract')->nullable();
//            $table->addColumn('work_type', 'work');
//            $table->string('description')->nullable();
//            $table->integer('min_order_amount')->nullable();
//            $table->string('criminal_record')->nullable();
//            $table->boolean('confirmed');
//            $table->decimal('rating', 1, 2)->nullable()->default(0);
        });
        DB::unprepared('ALTER TABLE users ADD COLUMN "gender" gender null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        \DB::unprepared('DROP TYPE gender');
    }
}
