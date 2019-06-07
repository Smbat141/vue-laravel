<?php

namespace App\Http\Controllers\Api;

use App\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{


    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $user = $request->user();
            return response()->json($user, 200);
        }
    }

    public function posts($id)
    {
        $user = User::find($id);
        $posts = $user->posts;
        return response()->json($posts, 200);
    }

    public function UserSubscriptions()
    {
        $user = auth()->user();
        $response = [];
        if ($user->stripe_id) {
            $response['card_last_four'] = $user->card_last_four;
            $response['customer_id'] = $user->stripe_id;

            if ($user->subscribedToPlan('plan_FASMxFBcGUkT0P', 'Monthly')) {
                $response['subscribe_plan'] = [
                    'name' => 'Monthly',
                    'plan_id' => 'plan_FASMxFBcGUkT0P'
                ];
            } else if ($user->subscribedToPlan('plan_FATJvPhOW3xHYV', 'Daily')) {
                $response['subscribe_plan'] = [
                    'name' => 'Daily',
                    'plan_id' => 'plan_FATJvPhOW3xHYV'
                ];
            } else {
                $response['subscribe_plan'] = false;
            }

            $response['card_brand'] = $user->card_brand;
        } else {
            $response = false;
        }
        return response()->json($response, 200);
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
