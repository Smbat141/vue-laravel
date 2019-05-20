<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Events\CommentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function sendMessage(Request $request){

        $comment = new Comment();
        $data['text'] = $request->input('message');
        $data['post_id'] = $request->input('channel');
        $data['user_id'] = $request->input('user_id');
        $comment->fill($data);
        $comment->save();
        event(new CommentEvent($request->all()));
	}


}
