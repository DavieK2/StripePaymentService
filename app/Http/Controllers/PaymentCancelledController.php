<?php

namespace App\Http\Controllers;


class PaymentCancelledController extends Controller
{
    public function index()
    {
        return view('payment.cancelled');
    }
}
