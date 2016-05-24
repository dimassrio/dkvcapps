<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
	protected $fillable = array('title', 'url');
	
	public function comments(){
		return $this->hasMany('App\Model\Comment', 'video_id');
	} 

	public function company(){
		return $this->belongsTo('App\Model\Company', 'comp_id');
	}

	public function toggleLike($user_id){
		$results =  \DB::select('select * from videos_likes where video_id = ? and user_id =?', [$this->id, $user_id]);
    	if(count($results)>0){
    		\DB::delete('delete from videos_likes where video_id = ? and user_id = ?', [$this->id, $user_id]);
    		return 'disabled';
    	}else{
    		$now = date('Y-m-d');

    		$result = \DB::insert('insert into videos_likes (video_id, user_id, created_at, updated_at) values (?, ?, ?,?)', [$this->id, $user_id, $now, $now]);
    		return 'enabled';
    	}
	}

	public function likeCount(){
		$results = \DB::select('select * from videos_likes where video_id = ?', [$this->id]);
    	return count($results);
	}

	public function likeList(){
		$result = \DB::select('select user_id from videos_likes where video_id = ?', [$this->id]);
    	$results = [];
    	foreach ($result as $key => $r) {
    		array_push($results, $r->user_id);
    	}
    	return $results;
	}
}
