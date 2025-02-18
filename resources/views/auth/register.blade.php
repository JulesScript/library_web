<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center w-full" style="background-color: #470303;">
        <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-input id="name"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 
               focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your name" />
                </div>

                <div class="mt-4">
                    <x-input id="email"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 
               focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="Enter your email" />
                </div>

                <div class="mt-4">
                    <x-input id="password"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 
               focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Enter your password" />
                </div>

                <div class="mt-4">
                    <x-input id="password_confirmation"
                        class="block mt-1 w-full text-white placeholder-gray-300 bg-gray-500 bg-opacity-30 border border-gray-400 
               focus:bg-opacity-50 focus:ring-2 focus:ring-white transition-all duration-300 ease-in-out px-4 py-2 text-lg"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm your password" />
                </div>


                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="ms-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>
</x-guest-layout>