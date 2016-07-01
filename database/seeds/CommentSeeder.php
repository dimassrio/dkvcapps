<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Comment;
use App\Model\Commenter;
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
        $commenter = Commenter::create(['email'=>'hello@doku.com', 'username'=>'admin', 'avatar'=>'http://placehold.it/480x480']);
        foreach(range(1, 100) as $key => $value){
        	$comments = Comment::create([
        		'comments' => $faker->text,
        		'parent' => 0,
        		'level' => 0,
        		'video_id' => rand(1, 99),
        		'user_id' => 1
        	]);
        }
    }
}
