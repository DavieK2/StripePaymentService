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

    public function store() : RedirectResponse
    {
        $checkoutUrl =  $this->paymentGateway->checkout();
        return redirect($checkoutUrl);
    }

    public function checkOutWebHook()
    {
        
    }

    public function paymentSuccessful()
    {
        return 'Hi alone';
    }

    public function paymentCancelled()
    {
        return 'Hi alone';
    }

}
