<?php

use Illuminate\Database\Seeder;

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
        // $this->call(UsersTableSeeder::class);
    }
}
