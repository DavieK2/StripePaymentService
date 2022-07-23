@extends('layout.app')

@section('content')
    <div class="flex flex-row space-x-10 focus:outline-none">
        <div class="text-xl font-bold pb-3 border-b border-gray-400">{{ isset($paymentMethod) ? 'Update Payment Method' : 'Create Payment Method'}}</div>
    </div>
    <form action="{{ isset($paymentMethod) ? route('payment.update', $paymentMethod->id) : route('payment.store') }}" method="POST">
        @csrf
        @isset($paymentMethod)
            @method('PATCH')
        @endisset

        <div class="flex flex-col space-y-3 w-full py-8">
           <div class="flex flex-col space-y-2">
            <label for="payment_method">Enter Payment Method</label>
            <input class="rounded-lg py-3 px-4 border border-gray-500 w-full" name="payment_method" type="text" value="{{  isset($paymentMethod) ? $paymentMethod->payment_method : old('payment_method') }}">
            @error('payment_method') <div class="text-sm text-red-600"> {{ $message}}</div> @enderror
           </div>
        </div>
        <button type="submit" class="py-3 px-4 text-white bg-blue-600 hover:bg-blue-800 rounded-lg w-full">{{ isset($paymentMethod) ? "Update Payment Method" : " Add Payment Method" }}</button>
    </form>
@endsection