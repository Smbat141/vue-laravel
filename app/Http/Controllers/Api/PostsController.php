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
use Stripe\Stripe;

class PostsController extends Controller
{
    public function index()
    {
        $mainPosts = Post::paginate(3);
        foreach ($mainPosts as $post) {
            $post->images->where('main', true);
            $post->user;
        }

        return response()->json($mainPosts, 200);
    }

    public function create()
    {
        //
    }

    public function store(PostsRequest $request)
    {
        if (isset($request->images)) {
            $dataPost = $request->except('_token', 'mainPicture', 'images', 'imageData');
            $post = new Post;
            $post->fill($dataPost);

            if ($post->save()) {
                foreach ($request->images as $index => $image) {
                    $postImageData = new PostImage();
                    if ($request->checkMain == $image->getClientOriginalName()) {
                        $postImageData->main = true;
                    } else {
                        $postImageData->main = false;
                    }
                    $postImageData->post_id = $post->id;
                    $postImageData->path = $image->store('uploads', 'public');
                    $postImageData->save();
                }
            }
            $user = Auth::user();
            $user->payment->post_pay = false;
            $user->payment->save();
        } else return response()->json('server error', 500);
    }

    public function show($id)
    {
        $post = Post::find($id);
        $comments = $post->comments()->orderBy('id', 'desc')->take(10)->paginate(5);
        foreach ($comments as $comment){
            $comment->user;
        }
        $post->images;
        $post->user->name;
        return response()->json(['post' => $post,'comments' => $comments], 200);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $user = Auth::user();
        $user->payment->post_pay = false;
        $user->payment->save();
        $role = $user->roles[0]->name;
        $data = $request->all();
        if ($role == 'admin' or $user->id == $request->user_id) {
            $post = Post::find($id);
            if (isset($request->images)) {
                foreach ($request->images as $index => $image) {
                    $postImageData = new PostImage();
                    if ($request->checkMain == $image->getClientOriginalName()) {
                        foreach ($post->images as $img) {
                            if ($img['main'] == 1) $img['main'] = 0;
                            $img->save();
                        }
                        $postImageData->main = true;
                    }
                    else{$postImageData->main = false;}

                    $postImageData->post_id = $post->id;
                    $postImageData->path = $image->store('uploads', 'public');
                    $postImageData->save();
                }

            }
            if(isset($request->checkMain) && strlen($request->checkMain) < 21 ){
                foreach ($post->images as $img){
                    if($img['main'] == 1) $img['main'] = 0;
                    $img->save();
                }
                $img = PostImage::find($request->checkMain);
                $img->main = 1;
                $img->save();
            }

            $post->fill($data);
            $post->save();
        }
    }
    public function destroy($id)
    {
        $post = Post::find($id);

        foreach ($post->images->toArray() as $val) {
            File::delete(unlink(public_path('storage/') . $val['path']));
        }
        dd(1);
        $post->comments()->delete();
        $post->delete();
        return response()->json('ok', 200);
    }

    public function deleteImage($id)
    {
        $image = PostImage::find($id);
        File::delete(unlink(public_path('storage/') . $image->path));
        $image->delete();
        return response()->json('ok', 200);

    }
    public function payment(Request $request){

        try{

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $token = $request->token['id'];
            $charge = \Stripe\Charge::create(array(
                'amount' => $request->amount,
                'currency' => 'usd',
                'description' => 'Pay for  post',
                'source' => $token,
            ));

            $user = Auth::user();
            $user->payment->post_pay = true;
            $user->payment->save();

        }catch (\Exception $e){

        }
    }
}

