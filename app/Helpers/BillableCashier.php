<?php

namespace App\Helpers;

use Laravel\Cashier\Billable;
use App\Helpers\SubscriptionBuilder;
use App\Subscription;

trait BillableCashier{
   use Billable;

    public function newSubscription($subscription, $plan)
    {
        return new SubscriptionBuilder($this, $subscription, $plan);
    }

    public function subscription($subscription = 'default')
    {
        return $this->subscriptions
            ->sortByDesc(function ($value) {
                return $value->created_at->getTimestamp();
            })
            ->first(function ($value) use ($subscription) {
                return $value->name === $subscription;
            });
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, $this->getForeignKey())->orderBy('created_at', 'desc');
    }
}
