<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
        DB::table('restaurants')->insert([
            'user_id' => 1,
            'name' => Str::random(10),
            'name_katakana' => Str::random(10),
            'review' => 1,
            'food_picture' =>  Str::random(10),
            'map_url' =>  Str::random(10),
            'created_at' => date("y-m-d"),
            'updated_at' => date("y-m-d"),
            'comment' => Str::random(50),
            'tel' => '080-xxxx-xxxx'
        ]);
    }
}
