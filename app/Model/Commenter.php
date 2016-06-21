<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Commenter extends Model
{
    protected $table = "commenters";

    protected $fillable = ['email', 'username', 'avatar'];
}
