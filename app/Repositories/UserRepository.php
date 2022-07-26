<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface {

    public function getUsers() : Collection
    {
        return User::get();
    }

    public function addUser(): void
    {
        $data = $this->validatedUserData();
        $data['password'] = Hash::make('password');
        User::create($data);
    }

    public function getUser(int $userId) : User
    {
       return $this->findUser($userId);
    }

    public function getUserPaymentMethods(int $userId) : Collection
    {
        return $this->findUser($userId)?->paymentMethods()->get();
    }

    public function addUserPaymentMethod(int $userId, int $paymentMethodId) : void
    {
        $paymentMethods = $this->findUser($userId)?->paymentMethods();

        $paymentMethods->syncWithoutDetaching([
            $paymentMethodId => [
                'is_default' => count($paymentMethods->get()) == 0 ? true : false 
                ]
            ]);
        
        //For Testing Purposes

        if(strtolower(PaymentMethod::find($paymentMethodId)->payment_method) == 'stripe'){
            StripeService::createStripeCustomer($userId);
        }
        
        
    } 

    public function updateUserDefaultPaymentMethod(int $userId, int $paymentMethodId) : void
    {   
        $user = $this->findUser($userId);
        $user?->paymentMethods->pluck('id')
                                ->map(fn($id) => $user?->paymentMethods()
                                                        ->syncWithoutDetaching([
                                                            $id => [
                                                                'is_default' => $id == $paymentMethodId ? true : false
                                                                ]
                                                            ])
                                                        );
    }

    public function removeUserPaymentMethod(int $userId, int $paymentMethodId) : void
    {
        $this->findUser($userId)?->paymentMethods()->detach($paymentMethodId);
    }

    public function deleteUser($userId): void
    {
        $this->findUser($userId)?->delete();
    }

    protected function findUser($userId) : null | User 
    {
        return User::findOrFail($userId);
    }

   
    protected function validatedUserData() : array
    {
        return request()->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
    }

}