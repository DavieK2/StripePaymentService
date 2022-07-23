<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface{

    public function addUser() : void;
    public function getUsers() : Collection;
    public function getUser($userId) : User;
    public function deleteUser($userId) : void;
    public function getUserPaymentMethods($userId) : Collection;
    public function addUserPaymentMethod($userId, $paymentMethodId) : void;
    public function updateUserDefaultPaymentMethod($userId, $paymentMethodId) : void;
    public function removeUserPaymentMethod($userId, $paymentMethodId) : void;
    
}