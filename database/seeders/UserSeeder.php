<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Buihuycuong\Vnfaker\VNFaker;
use Faker\Factory as FakerFactory;
use DB;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = FakerFactory::create();
        $arrImg = [
            'storage/users/fwTKqEpeFx6JmBqRlcyvOZZh9eaRb8Jt6hBSs0jD.jpg',
            'storage/users/QyNkgVyBVBVqw5bUsxI7oFEMhAKOVjwblIqCSepE.jpg',
            'storage/users/tlkvOFYKD6tL9vDfB1GpWnDgqIt2p2qLxk6cdr9P.jpg',
            'storage/users/tTaYVPlzNwSS3mUhrFjoi7cfXgDkvmtGJn3HJ3ZG.jpg',
            'storage/users/z2652684563122_1f56a0ceb7a6d03eb3827c0c97706f08.jpg',
            'storage/users/z2652685483858_d1804a86d6c8aeca6a3146b08e1d5eaa.jpg',
            'storage/users/z2652689385428_78e5bdca4d961130a28a63c86ee32ebe.jpg',
            'storage/users/z2652689488194_7cf9e3deba2435465f38987d7fa51c9e.jpg',
            'storage/users/z2652703686300_5ced2d41160daa6bee8557e69627332f.jpg',
            'storage/users/z2652705825390_cac9c9cc2e9f7ec758defd509ea9f7bb.jpg',
            'storage/users/z2652736200912_6d989af43867a10c5c752a4bc74f616e.jpg',
            'storage/users/z2652736290812_5d2efe7ec58e90c595b88f19e6c9c710.jpg',
            'storage/users/z2652732756511_0db048f1adef21365fc3444f6f81b2b5.jpg',
        ];
        for($i = 0; $i < 13; $i++){
            $data =[
                'name' => $faker->name,
                'provider_id' =>  Str::random(10),
                'first_name' => vnfaker()->firstame($word = 1),
                'last_name' => vnfaker()->lastname($word = 1),
                'email' => vnfaker()->email(),
                'password' => bcrypt(123456789),
                'avatar' => $arrImg[rand(0,12)],
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),

            ];
            DB::table('users')->insert($data);
        }

    }
}
