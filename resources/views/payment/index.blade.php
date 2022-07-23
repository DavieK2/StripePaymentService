@extends('layout.app')

@section('content')
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row space-x-10 focus:outline-none items-center">
            <a href="{{ url("/")  }}" class="text-xl font-bold pb-3 border-b border-gray-400 @if (url()->current() == url('/')) text-blue-600 @endif">Users</a>
            <a href="{{ url("/payment-methods")  }}" class="text-xl font-bold pb-3 border-b border-gray-400 @if (url()->current() == url('/payment-methods')) text-blue-600 @endif">Payment Methods</a>
        </div>
        <a href="{{ route('payment.create')  }}" class="px-3 py-2 text-sm bg-green-600 hover:bg-green-800 transition text-white rounded float-right">Add</a>
    </div>
    <ul class="mt-10">
        @if (session()->has('toggle_error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('toggle_error') }}</div>
        @endif
        @forelse ($paymentMethods as $paymentMethod)
            <li class="flex flex-row items-center justify-between py-4">
                <div class="flex flex-row items-center space-x-3">
                    <div class="h-8 w-1 bg-blue-600"></div>
                    <div class="flex flex-col">
                        <div class="font-semibold">{{ $paymentMethod->payment_method }} </div>
                    </div>
                </div>
                <div class="flex flex-row space-x-2">
                    <a href="#togglePaymentMethod" onclick="event.preventDefault(); document.getElementById('toggle{{ $paymentMethod->id }}').submit()" class="px-3 py-2 text-sm {{ !$paymentMethod->is_active ? 'bg-green-600 hover:bg-green-800' : 'bg-gray-600 hover:bg-gray-800' }}  transition text-white rounded">{{ !$paymentMethod->is_active ? 'Activate' : 'Deactivate' }}</a>
                    <a href="{{ route('payment.edit', $paymentMethod->id)  }}" class="px-3 py-2 text-sm bg-blue-600 hover:bg-blue-800 transition text-white rounded">Edit</a>
                    <a href="#deletePaymentMethod" onclick="event.preventDefault(); document.getElementById('delete{{ $paymentMethod->id }}').submit()" class="px-3 py-2 text-sm bg-red-600 hover:bg-red-800 transition text-white rounded">Delete</a>
                    <form hidden id="delete{{ $paymentMethod->id }}" action="{{ route('payment.destroy', $paymentMethod->id ) }}" method="post"> @csrf @method('DELETE')</form>
                    <form hidden id="toggle{{ $paymentMethod->id }}" action="{{ route('payment.toggle', $paymentMethod->id ) }}" method="post"> @csrf @method('PATCH')</form>
                </div>
            </li>
            
        @empty
            <div>No Payment found</div>
        @endforelse
    </ul>
@endsection