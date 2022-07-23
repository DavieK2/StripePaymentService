<?php

namespace App\Repositories;

use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

class PaymentMethodRepository implements PaymentMethodRepositoryInterface {

    public function addPaymentMethod(): void
    {
        $data = $this->validated();
        $data['class'] = 'App\Contracts\\'.trim(ucwords($data['payment_method'])).'PaymentGateway';
        PaymentMethod::create($data);
    }

    public function allPaymentMethods(): Collection
    {
        return PaymentMethod::get();
    }

    public function getActivePaymentMethods() : Collection
    {
        return PaymentMethod::where('is_active', true)->get();
    }

    public function updatePaymentMethod(int $paymentMethodId): void
    {
       $this->findPaymentMethod($paymentMethodId)?->update($this->validated());
    }

    public function deletePaymentMethod(int $paymentMethodId): void
    {
        $this->findPaymentMethod($paymentMethodId)?->delete();
    }

    public function editPaymentMethod(int $paymentMethodId): PaymentMethod
    {
        return $this->findPaymentMethod($paymentMethodId);
    }

    public function togglePaymentMethod(int $paymentMethodId): bool
    {
        $paymentMethod =  $this->findPaymentMethod($paymentMethodId);
        if(!class_exists($paymentMethod->class)) return false;
        return $paymentMethod?->update(['is_active' => $paymentMethod->is_active ? false : true ]);
    }

    protected function validated() : array
    {
        return request()->validate(['payment_method' => 'required|alpha']);
    }
    
    protected function findPaymentMethod(int $paymentMethodId) : null | PaymentMethod
    {
       return PaymentMethod::findOrFail($paymentMethodId);
    }
}