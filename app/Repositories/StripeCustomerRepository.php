<?php

namespace App\Repositories;

use App\Models\StripeCustomer;

class StripeCustomerRepository{

    public function checkIfCustomerExists($userId) : bool
    {
        return StripeCustomer::where('user_id', $userId)->exists() ? true : false;      
    }

    public function createStripeAccount(int $userId, string $customerId) : void
    {
        StripeCustomer::create(['user_id' => $userId, 'customer_id' => $customerId ]);
    }
    
}