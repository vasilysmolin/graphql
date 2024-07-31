<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{

        /**
         * Run the database seeds.
         */
        public function run()
    {
//        Article::truncate();
        Article::unguard();
        $faker = \Faker\Factory::create();
        User::all()->each(function ($user) use ($faker) {
            foreach (range(1, 5) as $i) {
                Article::create([
                    'user_id' => $user->id,
                    'title'   => $faker->sentence,
                    'content' => $faker->paragraphs(3, true),
                ]);
            }
        });
    }
}
