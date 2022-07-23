<?php

namespace App\Contracts;

use App\Interfaces\PaymentGatewayInterface;

class CashPaymentGateway implements PaymentGatewayInterface{

 
    public function checkout(string $userId) : string
    {
        return '/checkout/cash';
    }

    public function checkoutSessionWebhook() : void
    {
          
    }

    public function creatPayment($event) : void
    {
       
    }

    public function refund(int $paymentId) : void
    {
        
    }

}