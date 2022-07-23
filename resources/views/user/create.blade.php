@extends('layout.app')

@section('content')
    <div class="flex flex-row space-x-10 focus:outline-none">
        <div class="text-xl font-bold pb-3 border-b border-gray-400">Add User</div>
    </div>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="flex flex-col space-y-3 w-full py-8">
           <div class="flex flex-col space-y-2">
            <label for="name">Enter user full name</label>
            <input class="rounded-lg py-3 px-4 border border-gray-500 w-full" name="name" type="text" value="{{ old('name') }}">
            @error('name') <div class="text-sm text-red-600"> {{ $message}}</div> @enderror
           </div>
           <div class="flex flex-col space-y-2">
            <label for="email">Enter user email</label>
            <input class="rounded-lg py-3 px-4 border border-gray-500 w-full" name="email" type="email" value="{{ old('email') }}">
            @error('email') <div class="text-sm text-red-600"> {{ $message}}</div> @enderror
           </div>
        </div>
        <button type="submit" class="py-3 px-4 text-white bg-blue-600 hover:bg-blue-800 rounded-lg w-full">Add New User</button>
    </form>
@endsection