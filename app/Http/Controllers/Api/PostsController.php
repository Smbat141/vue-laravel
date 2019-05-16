<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PostsRequest;
use App\Post;
use App\PostImage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use File;

class PostsController extends Controller
{
    public function index()
    {
        $mainsPosts = Post::paginate(3);
        foreach ($mainsPosts as $posts) {
            $posts->images->where('main', true);
        }

        return response()->json($mainsPosts, 200);
    }

    public function create()
    {
        //
    }

    public function store(PostsRequest $request)
    {

        if (count($request->imageData)) {
            $dataPost = $request->except('_token', 'mainPicture', 'images', 'imageData');
            $post = new Post;
            $post->fill($dataPost);

            if ($post->save()) {
                foreach ($request->imageData as $index => $image) {
                    $postImageData = new PostImage();
                    if ($image->getClientOriginalName() == $request->mainPicture) {
                        $postImageData->main = true;
                    } else {
                        $postImageData->main = false;
                    }
                    $postImageData->post_id = $post->id;
                    $postImageData->path = $image->store('uploads', 'public');
                    $postImageData->save();
                }
            }

        } else return response()->json('server error', 500);
    }

    public function show($id)
    {
        $post = Post::find($id);
        $post->images;
        return response()->json($post, 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $role = $user->roles[0]->name;
        if ($role == 'admin' or $user->id == $request->user_id)

            $data = $request->except('images');
        $post = Post::find($id);
//        $length = $post->images->toArray();
        foreach ($request->imageData as $index => $image) {
            $postImageData = new PostImage();
            if ($image->getClientOriginalName() == $request->mainPicture) {
                $postImageData->main = true;
            } else {
                $postImageData->main = false;
            }
            $postImageData->post_id = $post->id;
            $postImageData->path = $image->store('uploads', 'public');
            $postImageData->save();
        }

        $post->fill($data);
        $post->save();
        return response()->json('Update successfully', 200);


    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $path = [];
        foreach ($post->images->toArray() as $val) {
            File::delete(unlink(public_path('storage/') . $val['path']));
        }
        $post->delete();
        return response()->json('ok', 200);
    }

    public function deleteImage($id)
    {
        $image = PostImage::find($id);

//        dd($image->main);
        $image->delete();

        return response()->json('ok', 200);

    }
}
