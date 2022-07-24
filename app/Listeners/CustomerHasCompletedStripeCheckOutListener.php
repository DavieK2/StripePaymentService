<?php

namespace App\Listeners;

use App\Contracts\StripePaymentGateway;
use App\Events\CustomerHasCompletedStripeCheckOutEvent;
use Illuminate\Support\Facades\Log;

class CustomerHasCompletedStripeCheckOutListener
{

    public function handle(CustomerHasCompletedStripeCheckOutEvent $event)
    {
        Log::info("$$event->checkoutEventData");
    }
}
