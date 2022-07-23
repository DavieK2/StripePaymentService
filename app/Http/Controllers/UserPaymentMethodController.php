<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class UserPaymentMethodController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($userId, $paymentMethodId) : RedirectResponse
    {
        $this->userRepository->addUserPaymentMethod($userId, $paymentMethodId);
        return back();
    }

    public function update($userId, $paymentMethodId) : RedirectResponse
    {
        $this->userRepository->updateUserDefaultPaymentMethod($userId, $paymentMethodId);
        return back()->withFragment('user-payment-methods');
    }

    public function destroy($userId, $paymentMethodId) : RedirectResponse
    {
        $this->userRepository->removeUserPaymentMethod($userId, $paymentMethodId);
        return back();
    }
}
