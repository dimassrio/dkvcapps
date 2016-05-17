<?php
namespace App\Modules\Api\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Model\Video;
use App\Transformer\CommentsTransformer;
use App\Model\Comment;
use League\Fractal;
/**
 * @Resource("Comments")
 */
class CommentsController extends ApiController
{
	public $video;
	public $transformer;
	public $comment;
	public function __construct(Video $video, Comment $comment, CommentsTransformer $transformer){
		$this->video = $video;
		$this->comment = $comment;
		$this->transformer = $transformer;
	}

	/**
	 * [getAll get all comment in one video]
	 * @Get("/video/{id}/comments")
	 * @Response(200, body={"comments":"Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.","level":0,"parent":0, "uri":"comments/1", "user_id":1, "flag":3, "video":{"data":{}}, "flaglist":"[1,2,3]"})
	 */
	public function getAll($id){
		$results = $this->video->find($id);
		$results = $results->comments;
		return $this->response->collection($results, $this->transformer);
	}

	public function getUsers($id){
		$results = $this->video->find($id);
		$results = $results->comments;
		$result = [];
		foreach($results as $r){
			if(!in_array($r->user_id, $result)){
				array_push($result, $r->user_id);
			}
		}
		return $this->response->array($result);
	}
	/**
	 * [getEntity get commnet entity]
	 * @Get("/comments/{id}")
	 * @Response(200, body={"comments":"Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.","level":0,"parent":0, "uri":"comments/1", "user_id":1, "flag":3, "video":{"data":{}}, "flaglist":"[1,2,3]"})
	 */
	public function getEntity($id){
		$results = $this->comment->find($id);
		if(!is_null($results)){
		return $this->response->item($results, $this->transformer);
		}
		return $this->response->notFound();
	}
	/**
	 * [postEntity post comment entity]
	 * @Post("/video/{id}/comments")
	 * @Request({"comments":"Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.", "user_id":1, "level":0, "parent":0})
	 * @Response(200, body={"comments":"Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.","level":0,"parent":0, "uri":"comments/1", "user_id":1, "flag":3, "video":"{}", "flaglist":"[1,2,3]"})
	 */
	public function postEntity($id, Request $request){
		$results = $this->comment->create([
			'comments' => $request->input('comments'),
			'user_id' => $request->input('user_id'),
			'video_id' => $id,
			'level' => $request->input('level', 0),
			'parent' => $request->input('parent', 0)
		]);

		return $this->response->item($results, $this->transformer);

	}
	/**
	 * [deleteEntity delete comment entity]
	 * @Delete("comments/{id}")
	 * @Response(203)
	 */
	public function deleteEntity($id){
		$results = $this->comment->find($id);
		if(!is_null($results)){
			$results->delete();
			return $this->response->noContent();
		}
		return $this->response->notFound();
	}

	/**
	 * [toggleFlag add or remove comment flag]
	 * @Post("comments/{id}/flag")  [type]  $id      [description]
	 * @Request({"user_id":1})
	 * @Response(201)
	 */
	public function toggleFlag($id, Request $request){
		$results = $this->comment->find($id);
		$results = $results->toggleFlag($request->input('user_id'));
		if($results == 'enabled'){
			return $this->response->created();
		}
		return $this->response->noContent();
	}

}