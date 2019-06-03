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
            return response()->json($user,200);
        }
    }

    public function posts($id){
        $user = User::find($id);
        $posts = $user->posts;
        return response()->json($posts,200);
    }

    public function  Subscribe(Request $request){
        $token = $request->id;

        auth()->user()->newSubscription('Monthly', 'plan_FASMxFBcGUkT0P')->create($token);
        //$userPaymonts = auth()->user()->payment();
        //$user->subscription('Monthly')->swap('plan_FATJvPhOW3xHYV');
        //$user->subscribedToPlan('plan_FATJvPhOW3xHYV','Monthly') ? $monthly = true: $monthly=false; // first param  plan_id

        return response()->json('ok');
    }

    public function UserSubscriptions(){
        $user = auth()->user();
        if ($user->subscribedToPlan('plan_FASMxFBcGUkT0P','Monthly')) {
            return response()->json(true);
        }
        else{
            return response()->json(false);
        }

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
