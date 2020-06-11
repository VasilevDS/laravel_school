<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');
        $students = [];

        for ($i = 11; $i <= 50; $i++) {
            $students[] = [
                'user_id' => $i,
                'phone' => $faker->phoneNumber,
            ];
        }

        DB::table('students')->insert($students);
    }
}
