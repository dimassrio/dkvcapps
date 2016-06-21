<?php

namespace App\Modules\Api\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Transformer\CommenterTransformer;
use App\Model\Commenter;

class CommenterController extends ApiController
{
	protected $transformer;
	protected $commenter;

	public function __construct(Commenter $commenter, CommenterTransformer $transformer){
		$this->commenter = $commenter;
		$this->transformer = $transformer;
	}

    public function registerOrUpdate(Request $request){
    	$email = $request->input('email');
    	$commenter = $this->commenter->where('email', $email)->get()->first();

    	if(!is_null($commenter)){
    		// bila info sudah ada cek bila ada perubahan
    		if($request->has('username')){
    			$commenter->username = $request->input('username');
    		}

    		if($request->has('avatar')){
    			$commenter->avatar = $request->input('avatar');
    		}
    		$commenter->save();
    		$results = $commenter;

    	}else{
    		// bila info tidak ada, registrasikan user
    		$validator = \Validator::make($request->all(), [
    			'email' => 'required',
    			'username' => 'required',
    			'avatar' => 'required',
    		]);

    		if($validator->fails()){
    			return $this->response->errorBadRequest($validator->errors());
    		}

    		$results = $this->commenter->create([
    			'email' => $request->input('email'),
    			'username' => $request->input('username'),
    			'avatar' => $request->input('avatar'),
    		]);

    	}

    	return $this->response->item($results, $this->transformer);
    }
}
