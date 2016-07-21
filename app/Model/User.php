<?php

namespace App\Model;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{

  public $fillable = ["first_name", "last_name", "password", "email", "cobrand_id"];

  public function cobrand(){
      if($this->cobrand_id > 0){
          return $this->belongsTo('App\Model\Company', 'cobrand_id');
      }
  }
}
