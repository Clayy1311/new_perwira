<x-guest-layout>
    <x-auth-card>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600  text-white   hover:text-white dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4  ">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="flex items-center justify-center mt-6">
            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
            <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
        </div>

       {{-- Tombol Daftar dengan Google --}}
<div class="flex items-center justify-center mt-6">
    <a href="{{ route('auth.google.redirect') }}"
       class="flex items-center gap-3 px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-md hover:bg-gray-100 transition duration-200 ease-in-out text-gray-700 font-medium">
        <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google Logo" class="w-5 h-5">
        <span>Continue with Google</span>
    </a>
</div>

        {{-- Pesan Sukses atau Error dari Google Login/Registrasi --}}
        @if (session('success'))
            <div class="mt-4 text-green-600 dark:text-green-400 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('google_auth')) {{-- Sesuaikan dengan key error di controller Anda --}}
            <div class="mt-4 text-red-600 dark:text-red-400 text-sm text-center">
                {{ $errors->first('google_auth') }}
            </div>
        @endif

    </x-auth-card>
</x-guest-layout>