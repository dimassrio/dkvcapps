<?php

namespace App\Transformer;
use App\Model\Video;
use League\Fractal;
use App\Model\Company;

class VideoTransformer extends Fractal\TransformerAbstract
{
	protected $defaultIncludes = [
		'company'
	];

	public function transform(Video $video)
	{
		return [
			'id'     => (int) $video->id,
			'title'  => $video->title,
			'url' 	 => $video->url,
			'description' 	 => $video->description,
			'rel'	 => 'self',
			'entity' => '/video/'.$video->id,
			'cobrand_id'=> $video->cobrand_id,
			'like_list' => $video->likeList(),
			'like_count' => $video->likeCount()
		];
	}

	public function includeCompany(Video $video){
		$results = $video->company;
		if(!is_null($results)){
			return $this->item($results, new CompanyTransformer);
		}else{
			return null;
		}
	}

	
}
