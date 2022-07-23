<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
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

    public function getUser($userId) : User
    {
       return $this->findUser($userId);
    }

    public function getUserPaymentMethods($userId) : Collection
    {
        return $this->findUser($userId)?->paymentMethods()->get();
    }

    public function addUserPaymentMethod($userId, $paymentMethodId) : void
    {
        $paymentMethods = $this->findUser($userId)?->paymentMethods();

        $paymentMethods->syncWithoutDetaching([
            $paymentMethodId => [
                'is_default' => count($paymentMethods->get()) == 0 ? true : false 
                ]
            ]);
    } 

    public function updateUserDefaultPaymentMethod($userId, $paymentMethodId) : void
    {   
        $user = $this->findUser($userId);
        $user?->paymentMethods()->get()->pluck('id')
                                ->map(fn($id) => $user?->paymentMethods()
                                                        ->syncWithoutDetaching([
                                                            $id => [
                                                                'is_default' => $id == $paymentMethodId ? true : false
                                                                ]
                                                            ])
                                                        );
    }

    public function removeUserPaymentMethod($userId, $paymentMethodId) : void
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