<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','content','user_id'];


    public function images(){
    	return $this->hasMany('App\PostImage','post_id');
	}
}
