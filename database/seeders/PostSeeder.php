<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Buihuycuong\Vnfaker\VNFaker;
use Faker\Factory as FakerFactory;
use DB;
class PostSeeder extends Seeder
{

    public function run()
    {
        $faker = FakerFactory::create();

        for($i = 0; $i < 13; $i++){
            $data =[
                'title' =>  $faker->title,
                'content' => $faker->paragraph,
                'slug' => $faker->text(20),
                'user_id' => rand(31,46),
                'created_at' => now(),
            ];
            DB::table('posts')->insert($data);
        }
    }
}
