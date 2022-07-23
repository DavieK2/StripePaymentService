<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface{

    public function addUser() : void;
    public function getUsers() : Collection;
    public function getUser(int $userId) : User;
    public function deleteUser(int $userId) : void;
    public function getUserPaymentMethods(int $userId) : Collection;
    public function addUserPaymentMethod(int $userId, int $paymentMethodId) : void;
    public function updateUserDefaultPaymentMethod(int $userId, int $paymentMethodId) : void;
    public function removeUserPaymentMethod(int $userId, int $paymentMethodId) : void;
    
}