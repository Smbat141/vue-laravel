<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','content','user_id'];


    public function images(){
    	return $this->hasMany('App\PostImage','post_id');
	}

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getPosts($paginate = null){
        $mainPosts = $this->paginate($paginate);
        foreach ($mainPosts as $post) {
            $post->images->where('main', true);
            $post->user;
        }
        return $mainPosts;
    }
}
