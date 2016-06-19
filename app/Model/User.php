<?php

namespace App\Model;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    public function cobrand(){
        if($this->cobrand_id > 0){
            return $this->belongsTo('App\Model\Company', 'cobrand_id');
        }
    }  
}