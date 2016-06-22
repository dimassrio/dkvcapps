<?php

namespace App\Transformer;
use App\Model\Video;
use League\Fractal;
use App\Model\Comment;

class CommentsTransformer extends Fractal\TransformerAbstract
{
	protected $defaultIncludes = [
		'video', 'user'
	];

	protected $availableIncludes = [
        
    ];

	public function transform(Comment $comment)
	{
		return [
			'comments' => $comment->comments,
			'level' => $comment->level,
			'parent' => $comment->parent,
			'uri' => 'comment/'.$comment->id,
			'user_id' => $comment->user_id,
			'flag' => $comment->flagCount(),
			'flag_list' => $comment->flagList(),
			'created_at' => $comment->created_at
		];
	}

	public function includeVideo(Comment $comment){
		$results = $comment->video;
		if(!is_null($results)){
			return $this->item($results, new VideoTransformer);
		}else{
			return null;
		}
	}

	public function includeUser(Comment $comment){
		$results = $comment->user;
		if(!is_null($results)){
			return $this->item($results, new CommenterTransformer);
		}else{
			return null;
		}
	}

	public function includeParents(Comment $comment){
		$results = $comment->parents();
		if(!is_null($results)){
			return $this->item($results, new CommentsTransformer);
		}
	}

	public function includeChilds(Comment $comment){
		$results = $comment->childs();
		if(!is_null($results)){
			return $this->item($results, new CommentCollectionTransformer);
		}
	}
}
