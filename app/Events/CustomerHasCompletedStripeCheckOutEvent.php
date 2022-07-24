<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerHasCompletedStripeCheckOutEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $checkoutEventData;

    public function __construct($checkoutEventData)
    {
        $this->checkoutEventData = $checkoutEventData;
    }

}
