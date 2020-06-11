<?php

use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');
        $teachers = [];

        for ($i = 1; $i <= 10; $i++) {
            $teachers[] = [
                'user_id' => $i,
                'phone' => $faker->phoneNumber,
            ];
        }

        DB::table('teachers')->insert($teachers);
    }
}
