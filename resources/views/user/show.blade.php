@extends('layout.app')

@section('content')
    <div class="flex flex-row space-x-10 focus:outline-none">
        <div class="text-xl font-bold pb-3 border-b border-gray-400 capitalize">{{ $user->name }}</div>
    </div>
    <ul class="mt-2">
        <div id="user-payment-methods" class="flex w-full text-lg text-gray-900 font-semibold py-4 bg-gray-100 rounded-lg px-6 my-8">Available Payment Methods</div>
        @forelse ($paymentMethods as $key => $paymentMethod)
            <li class="flex flex-row items-center justify-between py-4">
                <div class="flex flex-row items-center space-x-3">
                    <div class="h-12 w-1 bg-blue-600"></div>
                    <div class="font-semibold">{{ $paymentMethod->payment_method }}</div>
                </div>
                <div class="flex flex-row space-x-2">
                    @if ($paymentMethod->hasBeenAddedByUser($user->id))
                        <div class="text-gray-500 italic">Already added</div>
                    @else
                        <a href="#add" onclick="event.preventDefault(); document.getElementById('add{{ $paymentMethod->id }}').submit()" class="px-3 py-2 text-sm bg-green-600 hover:bg-green-800 transition text-white rounded">Add Payment Method</a>
                        <form hidden method="POST" id="add{{ $paymentMethod->id }}" action="{{ route('user.create.payment_method', [ 'userId' => $user->id, 'paymentMethodId' => $paymentMethod->id]) }}"> @csrf </form>
                    @endif
                </div>
               
            </li>
            
        @empty
            <div>No Payment Methods Found</div>
        @endforelse
    </ul>

    <ul class="mt-10">
        <div id="user-payment-methods" class="flex cursor-text w-full text-lg text-gray-900 font-semibold py-4 bg-gray-100 rounded-lg px-6 mb-8">User Payment Methods</div>
        @forelse ($userPaymentMethods as $userPaymentMethod)
            <li class="flex flex-row items-center justify-between py-4">
                <div class="flex flex-row items-center space-x-3">
                    <div class="h-12 w-1 bg-green-600"></div>
                    <div class="flex flex-row items-center space-x-1">
                        <div class="font-semibold">{{ $userPaymentMethod->payment_method }}</div>
                    </div>
                </div>
                <div class="flex flex-row space-x-3 items-center">
                    @if ($userPaymentMethod->pivot->is_default == false)
                        <a href="#makedefault" onclick="event.preventDefault(); document.getElementById('make-default{{ $userPaymentMethod->id }}').submit()"  class="px-3 py-2 text-sm bg-blue-600 hover:bg-blue-800 transition text-white rounded">Make Default</a>
                        <form hidden method="POST" id="make-default{{ $userPaymentMethod->id }}" action="{{ route('user.update.payment_method', [$user->id, $userPaymentMethod->id]) }}"> @csrf </form>
                    @endif
                   
                    @if ($userPaymentMethod->pivot->is_default == true)
                        <button disabled class="px-8 py-2 text-sm bg-gray-300 text-gray-800 rounded">Default</button>
                    @endif
                    <a href="#remove" onclick="event.preventDefault(); document.getElementById('delete{{$userPaymentMethod->id}}').submit()" class="px-3 py-2 text-sm bg-red-600 hover:bg-red-800 transition text-white rounded">Remove</a>
                    <form hidden method="POST" id="delete{{ $userPaymentMethod->id }}" action="{{ route('user.delete.payment_method', [$user->id, $userPaymentMethod->id]) }}"> @csrf </form>
                    
                </div>
            </li>
            
        @empty
            <div class="py-10">You haven't chosen a payment method</div>
        @endforelse
    </ul>

    @if ($user->default_payment_method == null)
        <button disabled class="flex justify-center py-4 px-8 w-full bg-gray-600 rounded-lg text-white text-base font-bold mt-16">Select a Default Payment Method</button>
    @else
        <a href="#checkout" onclick="event.preventDefault(); document.getElementById('checkout').submit();" class="flex justify-center py-4 px-8 w-full bg-blue-600 hover:bg-blue-800 rounded-lg text-white text-base font-bold mt-16">Proceed to checkout (Paying $20)</a>
        <form hidden id="checkout" action="{{ route('payment.checkout', $user->id) }}" method="POST"> @csrf <input hidden type="text" value="{{ $user->default_payment_method['id'] }}" name="payment_method"></form>
    @endif
@endsection
@section('stripe')
    <script src="https://js.stripe.com/v3/"></script>
@endsection