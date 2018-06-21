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
        $categories = [
            'Ремонтно-отделочные работы',
            'Строительство',
            'Архитектура, дизайн и проектирование',
            'Доставка, грузоперевозки',
            'Разнорабочие, грузчики',
            'Срочные работы (электрик, сантехник, монтаж сплит-систем)',
            'Строительная техника',
            'Клининг',
            'Вентиляция и кондиционирование',
            'Видеонаблюдение, домофоны, спутниковое ТВ',
            'Изготовление кухонь,шкафов и мебели' ,
            'Душевые кабины и изделия из стекла',
            'Окна',
            'Благоустройство и уход за территорией',
            'Экспертиза',
        ];
        $budget = [
            'до 1000',
            '1000-2000',
            '2000-3000',
            '3000-5000',
            '5000-7000',
            '7000-10000',
            '10-15 тыс.',
            '15-20 тыс.',
            '20-30 тыс.',
            '30-50 тыс.',
            '50-70 тыс.',
            '70-100 тыс.',
            '100-150 тыс.',
            '150-200 тыс.',
            '200-300 тыс.',
            '300-500 тыс.',
            '500-700 тыс.',
            '700 тыс.-1 млн.',
            '1-1,5 млн.',
            'более 1.5 млн.',
        ];
        foreach ($budget as $value) {
            DB::table('budget_scale')->insert(['interval' => $value]);
        }

        $roles = ['Исполнитель', 'Заказчик',  'Администратор'];
        for ($i = 0; $i < 3; $i++) {
            DB::table('roles')->insert([
                'title' => $roles[$i],
            ]);
        }

        foreach ($categories as $category) {
            DB::table('work_categories')->insert(['title' => $category]);
        }

        DB::table('users')->insert([
            'last_name' => 'Шонов',
            'first_name' => 'Виталий',
            'middle_name' => 'Витальевич',
            'phone' => '+7(988)5886912',
            'email' => 'v-shonov@mail.ru',
            'city' => 'Rostov',
            'password' => bcrypt('vfkmdbyf'),
        ]);
        $performer = User::all()->first();
        DB::table('users_work_categories')->insert([
            'user_id' => 1,
            'category_id' => 1,
        ]);
        DB::table('users_work_categories')->insert([
            'user_id' => 1,
            'category_id' => 2,
        ]);
        $role = DB::select("SELECT id FROM roles WHERE title='Исполнитель'");
        DB::table('user_roles')->insert(['user_id' => $performer->id, 'role_id' => $role[0]->id]);

        DB::table('users')->insert([
            'last_name' => 'Иванов',
            'first_name' => 'Иван',
            'middle_name' => 'Иванович',
            'phone' => '+7(918)5739352',
            'email' => 'ivanov@mail.ru',
            'city' => 'Rostov',
            'password' => bcrypt('vfkmdbyf'),
        ]);

        $customer = User::all()->last();
        $role = DB::select("SELECT id FROM roles WHERE title='Заказчик'");
        DB::table('user_roles')->insert(['user_id' => $customer->id, 'role_id' => $role[0]->id]);

        for ($i = 0; $i < 15; $i++) {
            [DB::table('orders')->insert([
                'title' => str_random(20),
                'description' => str_random(50),
                'start_date' => date("Y-m-d"),
                'address' => str_random(10),
                'coordinates' => '55 55',
                'budget_scale_id' => 1,
                'time_period' => 'В любое время',
                'user_id' => $customer->id,
            ])];
        }

        // $this->call(UsersTableSeeder::class);
    }
}
