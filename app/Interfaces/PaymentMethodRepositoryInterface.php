<?php

namespace App\Interfaces;

use App\Models\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepositoryInterface{
    public function addPaymentMethod() : void;
    public function getActivePaymentMethods() : Collection;
    public function allPaymentMethods() : Collection;
    public function editPaymentMethod(int $paymentMethodId) : PaymentMethod;
    public function updatePaymentMethod(int $paymentMethodId) : void;
    public function togglePaymentMethod(int $paymentMethodId) : bool;
    public function deletePaymentMethod(int $paymentMethodId) : void;
    public function findPaymentMethod(int $paymentMethodId) : null | PaymentMethod;
}