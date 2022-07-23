<?php

namespace App\Http\Controllers\API;

use App\Contracts\StripePaymentGateway;
use App\Http\Controllers\Controller;

class StripeWebhookPaymentController extends Controller
{
    private $stripePaymentGateway;


    public function __construct(StripePaymentGateway $stripePaymentGateway)
    {
        $this->stripePaymentGateway = $stripePaymentGateway;
    }

    public function create() : void
    {
        $this->stripePaymentGateway->checkoutSessionWebhook();   
    }
}
