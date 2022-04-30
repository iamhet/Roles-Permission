<?php

namespace Database\Seeders;

use App\Models\module2;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class Module2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i <= 1000; $i++) { 
            $module1 = new module2();
            $module1->firstName = $faker->firstName;
            $module1->lastName = $faker->lastName;
            $module1->email = $faker->email;
            $module1->save();
        }
    }
}
