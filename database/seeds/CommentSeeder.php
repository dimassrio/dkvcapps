<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Comment;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 100) as $key => $value){
        	$comments = Comment::create([
        		'comments' => $faker->text,
        		'parent' => 0,
        		'level' => 0,
        		'video_id' => 1,
        		'user_id' => $faker->numberBetween(1, 100)
        	]);
        }
    }
}
