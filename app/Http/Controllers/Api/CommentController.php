<?php

namespace App\Http\Controllers\Api;

use App\Events\CommentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function sendMessage(Request $request){
    	event(new CommentEvent($request->all()));
    	return $request->all();
	}
}
