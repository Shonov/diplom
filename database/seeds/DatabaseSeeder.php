<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ProfPlatforma\Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Заказчик', 'Исполнитель', 'Администратор'];
        for ($i = 0; $i < 3; $i++) {
            DB::table('roles')->insert([
                'title' => $roles[$i],
            ]);
        }

//        DB::table('users')->insert([
//            'last_name' => 'Иванов',
//            'first_name' => 'Иван',
//            'middle_name' => 'Иванович',
//            'phone' => '+7(988)5886912',
//            'email' => 'ivan12@mail.ru',
//            'city' => 'Rostov',
//            'password' => bcrypt('vfkmdbyf'),
//        ]);
        $user = User::all()->last();
        for ($i = 0; $i < 15; $i++) {
            [DB::table('orders')->insert([
                'title' => str_random(20),
                'description' => str_random(50),
                'start_date' => date("Y-m-d"),
                'address' => str_random(10),
                'coordinates' => '55 55',
                'budget_scale_id' => 1,
                'time_period' => 'В любое время',
                'user_id' => $user->id,
            ])];
        }

        // $this->call(UsersTableSeeder::class);
    }
}
