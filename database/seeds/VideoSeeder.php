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
        	$company = Company::create([
        		'name' => 'Doku',
            'ref_id'=> 675
        	]);

        $video = ['https://www.youtube.com/watch?v=Ej_DQ-Pk5nc', 'https://www.youtube.com/watch?v=mwaTVPAUGCg', 'https://www.youtube.com/watch?v=rITj6y15U-w'];
        foreach (range(1, 20) as $key => $value) {
        	$videos = Video::create([
        		'title' => 'Video '.$key,
                'description' => $faker->paragraph(),
        		'url' => $video[$faker->numberBetween(0,2)],
        		'cobrand_id' => 1
        	]);
        }
    }
}
