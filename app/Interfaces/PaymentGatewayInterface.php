<?php

namespace App\Interfaces;

interface PaymentGatewayInterface{

    public function checkout(string $userId) : string;
    public function checkoutSessionWebhook() : void ;
    public function creatPayment($event) : void;
    public function refund(int $paymentId) : void;
}