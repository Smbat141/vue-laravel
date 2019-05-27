<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
	protected $table = ('postImages');

	protected $fillable = ['post_id','path','main'];
}
