<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;

class RefundController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($paymentGatewayId)
    {
        $this->paymentGateway->refund($paymentGatewayId);
    }
}
