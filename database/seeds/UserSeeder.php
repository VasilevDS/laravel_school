<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');
        $users = [];

        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => $faker->password(),
                'role' => $i <= 10 ? 'teacher' : 'student',
            ];
        }

        DB::table('users')->insert($users);
    }
}
