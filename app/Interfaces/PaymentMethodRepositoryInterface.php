<?php

namespace App\Interfaces;

use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepositoryInterface{
    public function addPaymentMethod() : void;
    public function allPaymentMethods() : Collection;
    public function editPaymentMethod($paymentMethodId) : PaymentMethod;
    public function updatePaymentMethod($paymentMethodId) : void;
    public function deletePaymentMethod($paymentMethodId) : void;
}