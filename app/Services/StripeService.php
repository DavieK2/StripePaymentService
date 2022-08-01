<?php

namespace App\Services;

use App\Repositories\StripeCustomerRepository;
use Stripe\Stripe;

class StripeService{

    public static function createStripeCustomer(int $userId)
    {
        Stripe::setApiKey(config('app.stripe_api_key'));
        $customerRepository = new StripeCustomerRepository();

        if(! $customerRepository->checkIfCustomerExists($userId)){
            $customer = \Stripe\Customer::create();
            $customerRepository->createStripeAccount($userId, $customer->id);
        }
    }
}