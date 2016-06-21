<?php

namespace App\Transformer;
use App\Model\Video;
use League\Fractal;
use App\Model\Commenter;

class CommenterTransformer extends Fractal\TransformerAbstract
{

	public function transform(Commenter $commenter)
	{
		return [
			'id' => $commenter->id,
			'email' => $commenter->email,
			'username' => $commenter->username,
			'avatar' => $commenter->avatar
		];
	}

}
