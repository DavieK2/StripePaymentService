<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentMethodRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index() : View
    {
        $paymentMethods = $this->paymentMethodRepository->allPaymentMethods();
        return view('payment.index', compact('paymentMethods'));
    }

    public function create() : View
    {
        return view('payment.create');
    }

    public function edit($paymentMethodId) : View
    {
       $paymentMethod = $this->paymentMethodRepository->editPaymentMethod($paymentMethodId);
       return view('payment.create', compact('paymentMethod'));    
    }

    public function store() : RedirectResponse
    {
        $this->paymentMethodRepository->addPaymentMethod();
        return redirect()->route('payment.index');
    }

    public function update($paymentMethodId) : RedirectResponse
    {
        $this->paymentMethodRepository->updatePaymentMethod($paymentMethodId);
        return redirect()->route('payment.index');
    }

    public function destroy($paymentMethodId) : RedirectResponse
    {
        $this->paymentMethodRepository->deletePaymentMethod($paymentMethodId);
        return redirect()->route('payment.index');
    }
}
