<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Buihuycuong\Vnfaker\VNFaker;
use Faker\Factory as FakerFactory;
use DB;
class CommentSeeder extends Seeder
{

    public function run()
    {
        $faker = FakerFactory::create();

        for($i = 0; $i < 20; $i++){
            $data =[
                'parent_id' => rand(1,12),
                'post_id' => rand(54,66),
                'user_id' => rand(31,46),
                'content' => $faker->paragraph,
                'created_at' => now(),
            ];
            DB::table('comments')->insert($data);
        }
    }
}
