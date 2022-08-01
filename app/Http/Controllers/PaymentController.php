<?php

namespace App\Http\Controllers;

use App\Factories\PaymentGatewayFactory;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway =  PaymentGatewayFactory::make(request('payment_method'));
    }

    public function create($userId) : RedirectResponse
    {
        return redirect($this->paymentGateway->checkout($userId));
    }

    

}
