<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        {
            $faker = \Faker\Factory::create();
    
            for($i=0; $i<=50; $i++):
                DB::table('profiles')
                    ->insert([
                        'user_id' =>1,
                        'longitude' => rand(-710249872,-720249972)/10000000,
                        'latitude' => rand(47148399788965,4722271358311862)/1000000000000000,
                        'description' => $faker->paragraph,
                        'url' => 'prueba.com',
                        'url_instagram' => rand(0,1)?'instagram.com/prueba':null,
                        'whatsapp' => $faker->phoneNumber,
                        'text' => $faker->company,
                        'phone_number' => $faker->phoneNumber,
                        'category_id' => rand(17,18),
                        'rating' => rand(0,5)
                        
                    ]);
            endfor;
        }
    }
}
