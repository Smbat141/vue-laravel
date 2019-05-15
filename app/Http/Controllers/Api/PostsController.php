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
        $posts = Post::paginate(6);

        return response()->json($posts,200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        if(count($request->imageData)){
            $data = $request->except('_token');
            $data['images'] = array();
            foreach ($request->imageData as $index => $image){
                if($image->getClientOriginalName() == $request->mainPicture){
                    $data['main_image'] = $image->store('uploads','public');
                }
                $path = $image->store('uploads','public');
                array_push( $data['images'],$path);
            }
            /*dump($data['images']);/*/
            $post = new Post;
            $post->fill($data);

            if($post->save()){
                dd(1);

                return response()->json($data,200);
            }

        }






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
