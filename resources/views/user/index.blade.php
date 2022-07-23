@extends('layout.app')

@section('content')
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row space-x-10 focus:outline-none items-center">
            <a href="{{ url("/users")  }}" class="text-xl font-bold pb-3 border-b border-gray-400 @if (url()->current() == url('/')) text-blue-600 @endif">Users</a>
            <a href="{{ url("/payment-methods")  }}" class="text-xl font-bold pb-3 border-b border-gray-400 @if (url()->current() == url('/payment-methods')) @endif">Payment Methods</a>
        </div>
        <a href="{{ route('user.create')  }}" class="px-3 py-2 text-sm bg-green-600 hover:bg-green-800 transition text-white rounded float-right">Add</a>
    </div>
    <ul class="mt-10">
        @forelse ($users as $user)
            <li class="flex flex-row items-center justify-between py-4">
                <div class="flex flex-row items-center space-x-3">
                    <div class="h-12 w-1 bg-blue-600"></div>
                    <div class="flex flex-col">
                        <div class="font-semibold">{{ $user->name }} </div>
                        <div class="font-xs text-gray-400">{{ $user->email }} </div>
                    </div>
                </div>
                <div class="flex flex-row space-x-2">
                    <a href="{{ route('user.show', $user->id)  }}" class="px-3 py-2 text-sm bg-blue-600 hover:bg-blue-800 transition text-white rounded">View</a>
                    <a href="#deleteUser" onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit()" class="px-3 py-2 text-sm bg-red-600 hover:bg-red-800 transition text-white rounded">Delete</a>
                    <form id="delete{{ $user->id }}" action="{{ route('user.destroy', $user->id ) }}" method="post"> @csrf @method('DELETE')</form>
                </div>
            </li>
            
        @empty
            <div>No user found</div>
        @endforelse
    </ul>
@endsection