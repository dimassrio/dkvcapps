<?php
namespace App\Modules\Api\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Model\Video;
use App\Transformer\VideoTransformer;
/**
 * @Resource("Video")
 */
class VideoController extends ApiController
{
	public $video;

	public function __construct(Video $video, VideoTransformer $transformer){
		$this->video = $video;
		$this->transformer = $transformer;
	}
	/**
	 * [getAll get all JSON representation of all the video of doku.]
	 * @Get("/video")
	 * @Response(200, body={"id":1, "title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567", "created_at":"2000-01-01 00:00:00", "updated_at":"2000-01-01 00:00:00"})
	 * @Parameters({
	 *      @Parameter("limit", type="integer", required=false, description="add limit to returned json", default=100),
	 *      @Parameter("offset", type="integer", required=false, description="add offset to returned json and skip a couple id", default=0)
	 * })
	 */
	public function getAll(Request $request){
		$limit = $request->input('limit', 100);
		$offset = $request->input('offset', 0);
		$search = $request->input('search');
		if(!is_null($search)){
			if($limit>0){
				$results = $this->video->where('cobrand_id', $search)->skip($offset)->take($limit)->orderedBy('created_at', 'desc')->get();
			}else{
				$results = $this->video->where('cobrand_id', $search)->skip($offset)->orderedBy('created_at', 'desc')->get();
			}
		}else{
			if($limit>0){
				$results = $this->video->skip($offset)->take($limit)->orderedBy('created_at', 'desc')->get();
			}else{
				$results = $this->video->skip($offset)->orderedBy('created_at', 'desc')->get();
			}
		}
		return $this->response->collection($results, $this->transformer);
	}
	/**
	 * [getEntity get entity of a video.]
	 * @Get("/video/{id}")
	 * @Response(200, body={"id":1, "title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567", "created_at":"2000-01-01 00:00:00", "updated_at":"2000-01-01 00:00:00"})
	 */
	public function getEntity($id, Request $request){
		$results = $this->video->find($id);
		if(is_null($results)){
			return $this->response->errorNotFound();
		}
		return $this->response->item($results, $this->transformer);
	}

	/**
	 * [postEntity create a new entity of video and return its representaiton]
	 * @Post("/video")
	 * @Request({"title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567"})
	 * @Response(200, body={"id":1, "title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567", "created_at":"2000-01-01 00:00:00", "updated_at":"2000-01-01 00:00:00"})
	 */
	public function postEntity(Request $request){
		$validator = \Validator::make($request->all(), [
			'title'      => 'required',
			'url'        => 'required',
			'cobrand_id' => 'required'
		]);
		if($validator->fails()){
			return $this->response->errorBadRequest($validator->errors()->__toString());
		}
		$results = $this->video->create([
			'title'       => $request->input('title'), 
			'url'         => $request->input('url'), 
			'description' => $request->input('description') ,
			'cobrand_id'  => $request->input('cobrand_id')
		]);

		$results->company;
		return $this->response->item($results, $this->transformer);
	}

	/**
	 * [putEntity change the properties of an entity]
	 * @Put("/video/{id}")
	 * @Request({"title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567"})
	 * @Response(200, body={"id":1, "title":"Lorem Ipsum", "url": "http://youtube.com/watch?v=1234567", "created_at":"2000-01-01 00:00:00", "updated_at":"2000-01-01 00:00:00"})
	 */
	public function putEntity($id, Request $request){
		$results = $this->video->find($id);
		if(!is_null($results)){
			$results->title = $request->input('title', $results->title);
			$results->url = $request->input('url', $results->url);
			$results->description = $request->input('description', $results->description);
			$results->cobrand_id = $request->input('cobrand_id', $results->cobrand_id);
			$results->save();
			return $this->response->item($results, $this->transformer);
		}

		return $this->response->errorNotFound();
	}

	/**
	 * [deleteEntity delete entity]
	 * @Delete("/video/{id}")
	 * @Response(204)
	 */
	public function deleteEntity($id){
		$results = $this->video->find($id);
		if(!is_null($results)){
			$results->delete();
			return $this->response->noContent();
		}
		return $this->response->errorNotFound();
	}

	/**
	 * [toggleLike like or unlike a video]
	 * @Post  ("/video/{id}/like")
	 * @Transaction({
	 * 		@Request({"user_id":1}),
	 *  	@Response(201),
	 *  	@Response(204)
	 * })
	 */
	public function toggleLike($id, Request $request){
		$results = $this->video->find($id);
		if(!$request->has('user_id')){
			return $this->response->errorBadRequest();
		}
		$results = $results->toggleLike($request->input('user_id'));
		if($results == 'enabled'){
			return $this->response->created();
		}
		return $this->response->noContent();
	}

	/*
	 *
	 * 
	 */
	public function getAllLike($id, Request $request){
		$results = $this->video->find($id);
		if(is_null($results)){
			return $this->response->errorNotFound();
		}
		$results = $results->likeList();
		return $this->response->array($results);
	}

	public function getLikeCount($id, Request $request){
		$results = $this->video->find($id);
		if(is_null($results)){
			return $this->response->errorNotFound();
		}
		$results = $results->likeCount();
		return $this->response->array($results);
	}
}
