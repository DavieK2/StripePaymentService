<?php

namespace App\Factories;

use App\Contracts\CashPaymentGateway;
use App\Contracts\StripePaymentGateway;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentMethod;
use InvalidArgumentException;

class PaymentGatewayFactory{

    public static function make(string $type) : PaymentGatewayInterface
    {
        // return match($type){
        //     'stripe' => new StripePaymentGateway(),
        //     'cash' => new CashPaymentGateway(),
        //     default => throw new InvalidArgumentException('Payment Gateway Not Found')
        // }


        //Validate $type is not an empty string
        
        $paymentGateway = PaymentMethod::findOrFail($type)?->class;
            
        return new $paymentGateway();
    }
}