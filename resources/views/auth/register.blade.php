<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Logo/Header -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-uitm-purple">UniTrade</h1>
            <p class="mt-2 text-gray-600">Create a new account</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
            <x-text-input id="name"
                        class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple rounded-md shadow-sm"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input id="email"
                        class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple rounded-md shadow-sm"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
            <x-text-input id="password"
                        class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple rounded-md shadow-sm"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
            <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple rounded-md shadow-sm"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <!-- Register Button -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center px-4 py-2 bg-uitm-purple border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-uitm-purple-dark focus:bg-uitm-purple-dark active:bg-uitm-purple-dark focus:outline-none focus:ring-2 focus:ring-uitm-gold focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>

        <!-- Login Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-uitm-purple hover:text-uitm-purple-dark underline">
                    {{ __('Login') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
