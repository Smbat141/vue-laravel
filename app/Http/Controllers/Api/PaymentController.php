<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;

class PaymentController extends Controller
{

    public function UserCard(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = Auth::user();
        if(!isset($user->stripe_id)){
            $user->createAsStripeCustomer();
        }

        try {
            $token = \Stripe\Token::create([
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cvc
                ]
            ]);
            $user->updateCard($token->id);

            return response()->json('ok',200);

        } catch (\Exception $e) {
            return response()->json($e->jsonBody['error'],422);
        }
    }

    public function Subscribe(Request $request){
        $user = auth()->user();
        try{
            $user->newSubscription($request['plan_params']['name'], $request['plan_params']['plan_id'])->create(null);
            return response()->json(true);

        }
        catch (\Exception $e){
            return response()->json($e);
        }
    }

    public function ChangePlan(Request $request){
        $user = auth()->user();
       try{
           $user->subscription($request['current_plan'])->swap($request['plan_id'],$request['name']);
        return response()->json(true,200);
       }
       catch (\Exception $e){
           return response()->json($e->jsonBody,500);
       }

    }

    public function CancelSubscription(Request $request){
        $user = Auth::user();
//        dd($request['name']);
        try{
            $user->subscription($request['name'])->cancelNow();
            return response()->json(true,200);

        }
        catch (\Exception $e){
            return response()->json($e->jsonBody,500);

        }

    }

    public function CreatePost(Request $request){

        try {
            $user = Auth::user();
            $response = $user->charge(100,['description' => 'Pay for post']);
            return response()->json(true,200);

        } catch (Exception $e) {
            return response()->json($e,500);

        }

    }

}
