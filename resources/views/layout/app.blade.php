<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stemless Co Test Tak</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
            html{
                scroll-behavior: smooth;
            }
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>

        @vite('resources/css/app.css')
        @yield('stripe')
    </head>
    <body class="antialiased bg-gray-900  text-gray-800 pb-12">
      <div class="container flex flex-col items-center min-h-[100vh-3rem] mt-12">
        <h1 class="text-white text-center text-4xl p-6 font-bold">Stemless Co. Test Task</h1>

        <div class="flex flex-col w-[30rem] bg-white rounded p-6 overflow-x-hidden overflow-y-auto">
           @yield('content')
        </div>
      </div>
    </body>
</html>
