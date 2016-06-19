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
		$sidebars = [];
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
			// if  vendor
			$query = 'api/video?limit=0&search='.$users->cobrand_id;

		}
		$results = $this->api->get($query);		

		$collect = $results->forPage($request->input('page', 1), 20);
		$video = new LengthAwarePaginator($collect, count($results),20);
		$video->setPath('/dashboard/video');
		if(!is_null($search)){
			$video->setPath('/dashboard/video?search='.$search);
		}

		return view('frontend::dashboard.video.index', compact('users', 'sidebars', 'active', 'title', 'description', 'video'));
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
			// if  vendor
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
			$roles = \Sentinel::getRoleRepository()->where('slug','vendor')->get();
		}
		$options = $options->toJson();
		$roles = $roles->toJson();
		return view('frontend::dashboard.users.create', compact('title', 'description', 'active', 'users', 'options', 'roles'));
	}

	public function dashboardUsersPost(Request $request){
		foreach ($request->input('email') as $key => $value) {
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
		$title = 'Vendor Management';
		$description = 'Manage your Vendor here';
		$active = 'vendors';
		// querying
		
		// if admin
		if(\Sentinel::inRole('admin')){
			$search = $request->input('search');
			$query = $this->api->get('/api/company');
		}
		$results = $query;
		$collect = $results->forPage($request->input('page', 1), 20);
		$vendor_container = new LengthAwarePaginator($collect, count($results),20);

		$vendor_container->setPath('/dashboard/vendors');
		return view('frontend::dashboard.vendors.index', compact('title', 'description', 'active', 'users', 'vendor_container'));
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
			// delete vendor
			$results = $this->api->delete('api/company/'.$id);
		}

		return redirect()->to('/dashboard/vendors');
	}

	public function dashboardVendorCreate(){
		$users = \Sentinel::getUser();
		$title = 'Create Vendors';
		$description = 'Create the Vendors listing here';
		$active = 'vendors';
		return view('frontend::dashboard.vendors.create', compact('title', 'description', 'active', 'users'));
	}

	public function dashboardVendorPost(Request $request){

		foreach ($request->input('name') as $key => $value) {
			$this->api->post('/api/company', ['name' => $value, 'ref_id_'=> $request->input('ref_id_')[$key]]);
		}

		return redirect()->to('/dashboard/vendors');
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
