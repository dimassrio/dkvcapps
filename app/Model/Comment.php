<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "videos_comments";
	protected $fillable = array('comments', 'video_id', 'user_id', 'parent', 'level');

    public function video(){
    	return $this->belongsTo('App\Model\Video');
    }

    public function flagCount(){
    	$results = \DB::select('select * from comments_flag where comment_id = ?', [$this->id]);
    	return count($results);
    }

    public function toggleFlag($user_id){
    	$results =  \DB::select('select * from comments_flag where comment_id = ? and user_id =?', [$this->id, $user_id]);
    	if(count($results)>0){
    		\DB::delete('delete from comments_flag where comment_id = ? and user_id = ?', [$this->id, $user_id]);
    		return 'disabled';
    	}else{
    		$now = date('Y-m-d');

    		$result = \DB::insert('insert into comments_flag (comment_id, user_id, created_at, updated_at) values (?, ?, ?,?)', [$this->id, $user_id, $now, $now]);
    		return 'enabled';
    	}
    }

    public function flagList(){
    	$result = \DB::select('select user_id from comments_flag where comment_id = ?', [$this->id]);
    	$results = [];
    	foreach ($result as $key => $r) {
    		array_push($results, $r->user_id);
    	}
    	return $results;
    }

    public function user(){
    	return $this->belongsTo('App\Model\User');
    }

    public function parents(){
    	if($this->level = 0){
    		return $null;
    	}
    	$results = $this->where('id', $this->parent)->get()->first();
    	return $results;
    }

    public function childs(){
    	if($this->level>=3){
    		return null;
    	}
		$results = $this->where('parent', $this->id)->get();
		if(count($results)==0){
			return null;
		}
		return $results;
    }
}
