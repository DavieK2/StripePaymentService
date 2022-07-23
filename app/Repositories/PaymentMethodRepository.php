<?php

namespace App\Repositories;

use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface {

    public function addPaymentMethod(): void
    {
        PaymentMethod::create($this->validated());
    }

    public function allPaymentMethods(): Collection
    {
        return PaymentMethod::get();
    }

    public function updatePaymentMethod($paymentMethodId): void
    {
       $this->findPaymentMethod($paymentMethodId)?->update($this->validated());
    }

    public function deletePaymentMethod($paymentMethodId): void
    {
        $this->findPaymentMethod($paymentMethodId)?->delete();
    }

    public function editPaymentMethod($paymentMethodId): PaymentMethod
    {
        return $this->findPaymentMethod($paymentMethodId);
    }

    protected function validated() : array
    {
        return request()->validate(['payment_method' => 'required']);
    }
    
    protected function findPaymentMethod($paymentMethodId) : null | PaymentMethod
    {
       return PaymentMethod::findOrFail($paymentMethodId);
    }
}