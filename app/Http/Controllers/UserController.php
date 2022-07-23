<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentMethodRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
        $userPaymentMethods = $this->userRepository->getUserPaymentMethods($userId);
        
        return view('user.show' ,[
            'user' => $this->userRepository->getUser($userId),
            'userPaymentMethods' => $userPaymentMethods,
            'paymentMethods' => $this->paymentMethodRepository->allPaymentMethods(),
        ]);
    }

    public function destroy($userId) : RedirectResponse
    {
        $this->userRepository->deleteUser($userId);
        return back();
    }

}
