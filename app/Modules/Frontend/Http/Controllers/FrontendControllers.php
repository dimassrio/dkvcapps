<?php
namespace App\Modules\Frontend\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Model\Video;
use App\Model\Comment;
class FrontendControllers extends ApiController
{
	use Helpers;
	public function dashboardVideoIndex(Request $request){
		$users = \Sentinel::getUser();
		$active = 'video';
		$title = 'Video Management';
		$description = 'Manage all of your video information here.';

		// querying
		$search = $request->input('search');
		// if admin
		if(\Sentinel::inRole('admin')){
			$query = 'api/video?limit=0';
			if(!is_null($search)){
				$query = 'api/video?limit=0&search='.$search;
			}
		}else{
			// if  Cobrand
			$query = 'api/video?limit=0&search='.$users->cobrand_id;

		}
		$results = $this->api->get($query);	
		$collect = $results->forPage($request->input('page', 1), 20);
		$video = new LengthAwarePaginator($collect, count($results),20);
		$video->setPath('/dashboard/video');
		if(!is_null($search)){
			$video->setPath('/dashboard/video?search='.$search);
		}

		return view('frontend::dashboard.video.index', compact('users', 'active', 'title', 'description', 'video'));
	}

	public function dashboardVideoEdit($id, Request $request){
		$users = \Sentinel::getUser();
		$active = 'video';
		$title = 'Video Management';
		$description = 'Manage all of your video information here.';
		$video = $this->api->get('api/video/'.$id);
		if(\Sentinel::inRole('admin')){
			$options = $this->api->get('/company');
		}else{
			$options = $this->api->get('/company/'.$users->cobrand_id);
			$options = [$options];
		}
		return view('frontend::dashboard.video.edit', compact('users', 'active', 'title', 'description',  'video', 'options'));
	}

	public function dashboardVideoDelete($id){
		if(\Sentinel::inRole('admin')){
			$results = $this->api->delete('api/video/'.$id);
		}else{
			$results = $this->api->get('api/video/id');
			if(!is_null($results)){
				if($results->cobrand_id == \Sentinel::getUser()->cobrand_id){
					$results = $this->api->delete('api/video/'.$id);
				}
			}
		}

		return redirect()->to('/dashboard/video');
	}

	public function dashboardVideoPut($id, Request $request){
		$results = [];
		
		$this->api->put('api/video/'.$id, ['title'=>$request->input('title'), 'url'=>$request->input('url'),'description'=>$request->input('description') ,'cobrand_id'=>$request->input('cobrand_id')]);

		return redirect()->to('/dashboard/video');
	}

	public function dashboardUsersEdit($id, Request $request){
		$users = \Sentinel::getUser();
		$active = 'users';
		$title = 'Users Management';
		$description = 'Manage all of your users information here.';

		$users_container = \Sentinel::getUserRepository()->find($id);
		
		if(\Sentinel::inRole('admin')){
			$options = $this->api->get('/company');
			$roles = \Sentinel::getRoleRepository()->all();
		}else{
			$options = $this->api->get('/company/'.$users->cobrand_id);
		}
		return view('frontend::dashboard.users.edit', compact('users', 'active', 'title', 'description',  'users_container', 'options', 'roles'));
	}

	public function dashboardUsersPut($id, Request $request){
			$data = ["email"=>$request->input('email'), "password"=> $request->input('password'), "first_name"=>$request->input('first_name')];
			$validator = \Validator::make($data, [
				'email' => 'required',
				'first_name' => 'required'
			]);

			if($validator->fails()){
				return redirect()->to('/dashboard/users/'.$id.'/edit')->withErrors($validator);
			}

			$users = \Sentinel::findById($id);
			$credentials = [
				'email' => $request->input('email')
			];

			if(\Sentinel::validForUpdate($users, $credentials)){
				$update = [
					'first_name' => $request->input('first_name'),
					'last_name' => $request->input('last_name'),
					'role' => $request->input('role'),
					'cobrand_id' => $request->input('cobrand_id')
				];
				if($request->has('password')){
					$update['password'] = $request->input('password');
				}

				$roles = \Sentinel::getRoleRepository()->findBySlug('admin');
				if($roles->id == $request->input('role')){
					$update['cobrand_id'] = 0;
				}

				\Sentinel::update($users, $update);

			}
			return redirect()->to('/dashboard/users');
	}

	public function dashboardUsersDelete($id){
		if(\Sentinel::inRole('admin')){
			$results = \Sentinel::getUserRepository()->find($id);
			if($results->id != \Sentinel::getUser()->id){
				$results->delete();
			}
		}else{
			$results = \Sentinel::find($id);
			if(!is_null($results)){
				if($results->cobrand_id == \Sentinel::getUser()->cobrand_id){
					$results->delete();
				}
			}
		}

		return redirect()->to('/dashboard/users');
	}

	
	public function dashboardVideoCreate(){
		$users = \Sentinel::getUser();
		$title = 'Create Video';
		$description = 'Create the video listing here';
		$active = 'video';
		$options = array();
		if(\Sentinel::inRole('admin')){
			$options = $this->api->get('/company');
		}else{
			$options = $this->api->get('/company/'.$users->cobrand_id);
		}
		$options = $options->toJson();
		return view('frontend::dashboard.video.create', compact('title', 'description', 'active', 'users', 'options'));
	}

	public function dashboardVideoPost(Request $request){
		foreach ($request->input('title') as $key => $value) {
			$data = [
				"title"       => $value, 
				"url"         => $request->input('url')[$key], 
				"cobrand_id"  => $request->input('cobrand_id')[$key],
				"description" => $request->input('description')[$key]
			];
			$validator = \Validator::make($data, [
				'title' => 'required',
				'url' => 'required|url',
				'cobrand_id' => 'required'
			]);

			if($validator->fails()){
				return redirect()->to('/dashboard/create/video')->withErrors($validator);
			}

			$this->api->post('/api/video', ['title' => $value, 'url'=> $request->input('url')[$key], 'cobrand_id'=>$request->input('cobrand_id')[$key]]);
		}

		return redirect()->to('/dashboard/video');
	}

	public function dashboardUsersIndex(Request $request){
		$users = \Sentinel::getUser();
		$title = 'Users Management';
		$description = 'Manage your users here';
		$active = 'users';
		// querying
		
		// if admin
		if(\Sentinel::inRole('admin')){
			$search = $request->input('search');
			$query = \Sentinel::getUserRepository()->all();
		}else{
			// if  Cobrand
			$query = \Sentinel::getUserRepository()->where('cobrand_id', $users->cobrand_id)->get();
		}
		$results = $query;
		$collect = $results->forPage($request->input('page', 1), 20);
		$users_container = new LengthAwarePaginator($collect, count($results),20);

		$users_container->setPath('/dashboard/users');
		return view('frontend::dashboard.users.index', compact('title', 'description', 'active', 'users', 'users_container'));
	}

	public function dashboardUsersCreate(){
		$users = \Sentinel::getUser();
		$title = 'Create Users';
		$description = 'Create the Users listing here';
		$active = 'users';
		$options = array();
		if(\Sentinel::inRole('admin')){
			$options = $this->api->get('/company');

			$roles = \Sentinel::getRoleRepository()->all();
		}else{
			$options = $this->api->get('/company/'.$users->cobrand_id);
			$roles = \Sentinel::getRoleRepository()->where('slug','Cobrand')->get();
		}
		$options = $options->toJson();
		$roles = $roles->toJson();
		return view('frontend::dashboard.users.create', compact('title', 'description', 'active', 'users', 'options', 'roles'));
	}

	public function dashboardUsersPost(Request $request){
		foreach ($request->input('email') as $key => $value) {
			$data = ["email"=>$value, "password"=> $request->input('password')[$key], "first_name"=>$request->input('first_name')[$key]];
			$validator = \Validator::make($data, [
				'email' => 'required',
				'password' => 'required',
				'first_name' => 'required'
			]);

			if($validator->fails()){
				return redirect()->to('/dashboard/create/users')->withErrors($validator);
			}

			$credentials = [
				'email' => $value,
				'password' => $request->input('password')[$key]
			];

			$results = \Sentinel::registerAndActivate($credentials);
			$results->first_name = $request->input('first_name')[$key];
			$results->last_name = $request->input('last_name')[$key];
			$roles = \Sentinel::getRoleRepository()->where('slug','admin')->get();
			if($request->input('roles_id')[$key] == $roles->first()->id){
				$results->cobrand_id = 0;
				$results->save();
				$roles->first()->users()->attach($results);
			}else{
				$results->cobrand_id = $request->input('cobrand_id')[$key];
				$results->save();
				$roles = \Sentinel::getRoleRepository()->where('id', $request->input('roles_id')[$key])->get();
				$roles->first()->users()->attach($results);
			}
			$results->save();
		}

		return redirect()->to('/dashboard/users');
	}

	public function dashboardVendorIndex(Request $request){
		$users = \Sentinel::getUser();
		$title = 'Cobrand Management';
		$description = 'Manage your Cobrand here';
		$active = 'cobrands';
		// querying
		
		// if admin
		if(\Sentinel::inRole('admin')){
			$search = $request->input('search');
			$query = $this->api->get('/api/company');
		}
		$results = $query;
		$collect = $results->forPage($request->input('page', 1), 20);
		$vendor_container = new LengthAwarePaginator($collect, count($results),20);

		$vendor_container->setPath('/dashboard/cobrands');
		return view('frontend::dashboard.cobrands.index', compact('title', 'description', 'active', 'users', 'vendor_container'));
	}

	public function dashboardVendorDelete($id){
		if(\Sentinel::inRole('admin')){
			// delete user
			$results = \Sentinel::getUserRepository()->where('cobrand_id', $id)->get();
			foreach ($results as $key => $value) {
				$value->delete();
			}
			// delete video
			$results = $this->api->get('api/video?limit=0&search='.$id);
			foreach ($results as $key => $value) {
				$results = $this->api->delete('api/video/'.$value->id);
			}
			// delete Cobrand
			$results = $this->api->delete('api/company/'.$id);
		}

		return redirect()->to('/dashboard/cobrands');
	}

	public function dashboardVendorCreate(){
		$users = \Sentinel::getUser();
		$title = 'Create cobrands';
		$description = 'Create the cobrands listing here';
		$active = 'cobrands';
		return view('frontend::dashboard.cobrands.create', compact('title', 'description', 'active', 'users'));
	}

	public function dashboardVendorPost(Request $request){
		foreach ($request->input('name') as $key => $value) {
			$this->api->post('/api/company', ['name' => $value, 'ref_id_'=> $request->input('ref_id_')[$key]]);
		}
		return redirect()->to('/dashboard/cobrands');
	}

	public function dashboardVendorEdit($id){
		$users = \Sentinel::getUser();
		$active = 'cobrands';
		$title = 'Cobrand Management';
		$description = 'Manage all of your cobrand information here.';
		$cobrand_container = $this->api->get('/api/company/'.$id);
		return view('frontend::dashboard.cobrands.edit', compact('title', 'description', 'active', 'users', 'cobrand_container'));
	}
	public function dashboardVendorPut($id, Request $request){
		$validator = \Validator::make($request->all(),[
			'name' => 'required'
		]);

		if(!$validator->fails()){
			$this->api->put('/api/company/'.$id, ['name'=>$request->input('name', ''), 'ref_id'=>$request->input('ref_id', '')]);			
		}
		return redirect()->to('/dashboard/cobrands');
	}

	public function dashboardCommentsIndex($id, Request $request){
		$video = Video::find($id);
		$users = \Sentinel::getUser();
		$title = 'Comments Management';
		$description = 'Manage the comment from the users here.';
		$active = 'video';

		if(!\Sentinel::inRole('admin')){
			if($results->cobrand_id != $users->cobrand_id){
				return redirect()->to('/dashboard/videos');
			}
		}
		parse_str(parse_url($video->url)['query'], $embed);

		$results = $video->comments;
		$collect = $results->forPage($request->input('page', 1), 20);
		$comments_container = new LengthAwarePaginator($collect, count($results),20);
		$comments_container->setPath('/dashboard/comments/'.$id);

		return view('frontend::dashboard.comments.index', compact('title', 'description', 'active', 'users', 'comments_container', 'video', 'embed'));
	}

	public function dashboardCommentsDelete($id){
		$comments = Comment::find($id);
		$video_id = $comments->video_id;
		$comments->delete();
		return redirect()->to('/dashboard/comments/'.$video_id);
	}
}
