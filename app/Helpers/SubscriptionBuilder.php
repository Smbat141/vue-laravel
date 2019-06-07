<?php

namespace App\Helpers;
use Laravel\Cashier\Exceptions\SubscriptionCreationFailed;
use Laravel\Cashier\SubscriptionBuilder as CashierSubscriptionBuilder;

class SubscriptionBuilder extends CashierSubscriptionBuilder
{
    public function create($token = null, array $options = [])
    {
        $customer = $this->getStripeCustomer($token, $options);

        $subscription = $customer->subscriptions->create($this->buildPayload());

        if (in_array($subscription->status, ['incomplete', 'incomplete_expired'])) {
            $subscription->cancel();

            throw SubscriptionCreationFailed::incomplete($subscription);
        }

        if ($this->skipTrial) {
            $trialEndsAt = null;
        } else {
            $trialEndsAt = $this->trialExpires;
        }
        $quantity = null;

        if($this->name === 'Monthly'){
         $quantity = 45;
        }
        elseif ($this->name === 'Daily'){
            $quantity = 15;
        }
        else{
            $quantity;
        }
        return $this->owner->subscriptions()->create([
            'name' => $this->name,
            'stripe_id' => $subscription->id,
            'stripe_plan' => $this->plan,
            'quantity' => $this->quantity,
            'trial_ends_at' => $trialEndsAt,
            'ends_at' => null,
            'posts_quantity' => $quantity,
        ]);
    }

}
