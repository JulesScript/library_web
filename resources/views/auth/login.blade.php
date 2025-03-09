<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center w-full" style="background-color: #470303;">
        <x-authentication-card class="bg-white bg-opacity-10 backdrop-blur-md p-8 rounded-lg w-full max-w-4xl shadow-none">

            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
            @endif


            <label for="register" class="block text-white text-lg mb-5 text-center">Login Account</label>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input id="email"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email" />
                </div>
                <div class="mt-4">
                    <x-input id="password"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password" />
                </div>

                {{-- <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                </label>
    </div> --}}


    <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
            Don't have account? click here
        </a>

        <x-button class="ms-4 bg-white" style="color: #470303;">
            {{ __('Log in') }}
        </x-button>
    </div>

    <div class="flex items-center justify-end mt-4">
        {{-- @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-300 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
        {{ __('Forgot your password?') }}
        </a>
        @endif --}}


    </div>
    </form>
    </x-authentication-card>
    </div>
</x-guest-layout>