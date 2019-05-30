<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        if($request->expectsJson()){
            $user = $request->user();
            $user->payment;
            return response()->json($user,200);
        }
    }

    public function posts($id){
        $user = User::find($id);

        $posts = $user->posts;

        return response()->json($posts,200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
