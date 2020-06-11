<?php

use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ru_RU');
        $themes = [];

        for ($i = 1; $i <= 10; $i++) {
            $themes[] = [
                'name' => $faker->jobTitle,
            ];
        }

        DB::table('themes')->insert($themes);
    }
}
