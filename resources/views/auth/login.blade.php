<x-guest-layout>
    <!-- Session Status -->
    
    <x-auth-card>
        
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
     
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block= mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
 {{-- Divider --}}
 <div class="flex items-center justify-center mt-6">
    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
    <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
</div>

{{-- Tombol Daftar dengan Google --}}
{{-- Tombol Daftar dengan Google --}}
<div class="flex items-center justify-center mt-6">
    <a href="{{ route('auth.google.redirect') }}"
       class="flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-950 via-blue-950 to-blue-600
text-white rounded-lg shadow-md hover:bg-gray-100 transition duration-200 ease-in-out font-medium">
        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google Logo" class="w-5 h-5">
        <span>Continue with Google</span>
    </a>
</div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white  text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-card>
</x-guest-layout>
