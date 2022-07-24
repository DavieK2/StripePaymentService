<?php

namespace App\Interfaces;

interface PaymentGatewayInterface{

    public function checkout(string $userId) : string;
    public function createPayment($event) : void;
    public function refund(int $paymentId) : void;
}