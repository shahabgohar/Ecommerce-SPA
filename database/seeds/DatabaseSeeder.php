<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // $this->call(UsersTableSeeder::class);
//        for($i=0;$i<5;$i++)
//        {
//            DB::table('categories')->insert([
//                'category_name'=> $faker->name
//            ]);
//        }


    }
}
