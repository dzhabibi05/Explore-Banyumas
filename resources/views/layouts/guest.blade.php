<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center py-10 px-4" style="background-image: url('{{ asset('images/background-login-register.png') }}')">
        <div class="w-full max-w-lg flex flex-col items-center">
            <div class="mb-8">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto drop-shadow-md" />
                </a>
            </div>

            <div class="w-full bg-[#618559]/95 backdrop-blur-sm shadow-[0_20px_50px_rgba(0,0,0,0.15)] px-8 py-10 rounded-tl-[2rem] rounded-tr-[5.5rem] rounded-br-[2rem] rounded-bl-[5.5rem] border border-white/10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
