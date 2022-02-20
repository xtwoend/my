@extends('layouts.app')

@section('main')
<div class="row row-sm justify-content-center">
    <div class="col align-self-center col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4>Please sign in to continue</h4>
                <!-- Session Status -->
                {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}
                
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="text" class="form-control" placeholder="Enter your email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div><!-- form-group -->
                    <div class="form-group">
                        <label>{{ __('Password') }}</label>
                        <input type="password" class="form-control" placeholder="Enter your password"
                                    name="password"
                                    required autocomplete="current-password">
                    </div><!-- form-group -->
                    <button class="btn btn-primary btn-block">Sign In</button>
                </form>
            </div>
            {{-- <div class="card-footer text-center">
                <p><a href="">Forgot password?</a></p>
            </div> --}}
        </div>
    </div>
</div>
@endsection

{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
