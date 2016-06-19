<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $table = 'cobrand';

	protected $fillable = ['ref_id', 'name'];
    //
    public function video(){
    	return $this->hasMany('App\Model\Video');
    }

    public function users(){
    	return $this->hasMany('App\Model\User');
    }
}
