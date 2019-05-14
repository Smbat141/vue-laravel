<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PostsRequest;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {

        return response()->json(Post::all(),200);
    }


    public function create()
    {
        //
    }

    public function store(PostsRequest $request)
    {
        $data = $request->except('_token');

        $path = $request->file('image')->store('uploads','public');

        $data['image'] = $path;

        $post = new Post;
        $post->fill($data);
        if($post->save()){
            return response()->json($data,200);
        }
        return response()->json($request->all(),200);

    }


    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post,200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $role = $user->roles[0]->name;
        if($role == 'admin' or $user->id == $request->user_id)

        $data = $request->all();
        $post = Post::find($id);

        if($request->file){
            $path = $request->file('image')->store('uploads','public');
            $data['image'] = $path;

        }
        $post->fill($data);
        $post->save();
        return response()->json('Update successfully',200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json('ok',200);
    }
}
