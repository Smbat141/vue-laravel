<?php

namespace App;

use Carbon\Carbon;
use Laravel\Cashier\Exceptions\SubscriptionCreationFailed;
use LogicException;
use DateTimeInterface;
use Stripe\Error\Card as StripeCard;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription as CashierSubscription;


class Subscription  extends CashierSubscription
{
    //protected $fillable = ['posts_quantity','name'];

    public function swap($plan,$name = null)
    {
        $subscription = $this->asStripeSubscription();

        $subscription->plan = $plan;

        $subscription->prorate = $this->prorate;

        $subscription->cancel_at_period_end = false;

        if (! is_null($this->billingCycleAnchor)) {
            $subscription->billing_cycle_anchor = $this->billingCycleAnchor;
        }

        // If no specific trial end date has been set, the default behavior should be
        // to maintain the current trial state, whether that is "active" or to run
        // the swap out with the exact number of days left on this current plan.
        if ($this->onTrial()) {
            $subscription->trial_end = $this->trial_ends_at->getTimestamp();
        } else {
            $subscription->trial_end = 'now';
        }

        // Again, if no explicit quantity was set, the default behaviors should be to
        // maintain the current quantity onto the new plan. This is a sensible one
        // that should be the expected behavior for most developers with Stripe.
        if ($this->quantity) {
            $subscription->quantity = $this->quantity;
        }

        $subscription->save();

        try {
            $this->user->invoice(['subscription' => $subscription->id]);
        } catch (StripeCard $exception) {
            // When the payment for the plan swap fails, we continue to let the user swap to the
            // new plan. This is because Stripe may attempt to retry the payment later on. If
            // all attempts to collect payment fail, webhooks will handle any update to it.
        }

        $this->fill([
            'name' => $name,
            'stripe_plan' => $plan,
            'ends_at' => null,
            'posts_quantity' => 5,
        ])->save();

        return $this;
    }

}
