<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userRepository;
    private $paymentMethodRepository;

    public function __construct(UserRepositoryInterface $userRepository, PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->userRepository = $userRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index() : View
    {
        return view('user.index',  [
            'users' => $this->userRepository->getUsers()
        ]);
    }

    public function create() : View
    {
        return view('user.create');
    }

    public function store() : RedirectResponse
    {
        $this->userRepository->addUser();
        return redirect()->route('user.index');
    }

    public function show($userId) : View
    {
        $user = $this->userRepository->getUser($userId);
        $userPaymentMethods = $this->userRepository->getUserPaymentMethods($userId);
        session(['defaultPaymentMethodId' => $user->default_payment_method]);

        return view('user.show' ,[
            'user' => $user,
            'userPaymentMethods' => $userPaymentMethods,
            'paymentMethods' => $this->paymentMethodRepository->getActivePaymentMethods(),
        ]);
    }

    public function destroy($userId) : RedirectResponse
    {
        $this->userRepository->deleteUser($userId);
        return back();
    }

}
