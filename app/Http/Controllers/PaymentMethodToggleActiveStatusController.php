<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentMethodRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class PaymentMethodToggleActiveStatusController extends Controller
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function update($paymentMethodId) : RedirectResponse
    {
        $isToggled =  $this->paymentMethodRepository->togglePaymentMethod($paymentMethodId);
        return $isToggled ? back() : back()->with('toggle_error', 'Payment Method is not yet Implemented');
    }
}
