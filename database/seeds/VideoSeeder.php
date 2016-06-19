<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Video;
use App\Model\Company;
class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1, 10) as $key => $value){
        	$company = Company::create([
        		'name' => $faker->company()
        	]);
        }
        $video = ['https://www.youtube.com/watch?v=Ej_DQ-Pk5nc', 'https://www.youtube.com/watch?v=mwaTVPAUGCg', 'https://www.youtube.com/watch?v=rITj6y15U-w'];
        foreach (range(1, 100) as $key => $value) {
        	$videos = Video::create([
        		'title' => $faker->sentence(),
        		'url' => $video[$faker->numberBetween(0,2)],
        		'cobrand_id' => $faker->numberBetween(1, 10)
        	]);
        }
    }
}
