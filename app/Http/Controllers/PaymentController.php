<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function create($userId) : RedirectResponse
    {
        $checkoutUrl =  $this->paymentGateway->checkout($userId);
        return redirect($checkoutUrl);
    }

    public function store() : void
    {
        $this->paymentGateway->checkoutSessionWebHook();
    }

}
