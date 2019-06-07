<?php

namespace App\Http\Middleware;

use Closure;

class PaymentRoles
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $subscribe_plan = $user->subscriptions->where('stripe_plan', $request['plan_id'])->first();

        if ($subscribe_plan['posts_quantity'] <= 20) {
            return response()->json(false);
        }
        elseif ($request->accept == true){
            return $next($request);
        }
        return $next($request);

    }
}
