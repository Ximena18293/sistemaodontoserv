<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="max-w-lg mx-auto mt-8 p-6 border border-gray-300 rounded-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-center">{{ __('Change Password') }}</h2>
                
                    <form method="POST" action="{{ route('updateUser') }}">
                        @csrf
                
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('New Password') }}</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full" required>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full" required>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="">
                            <button type="submit" class="btn btn-success">
                                {{ __('Change Password') }}
                            </button>
                        </div>
                    </form>
                </div><!-- Cierra la sección del slot -->
                
            </div>
        </div>
    </body>
</html>
