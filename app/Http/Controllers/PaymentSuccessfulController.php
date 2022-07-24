<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentSuccessfulController extends Controller
{
    public function index()
    {
        return view('payment.success');
    }
}
