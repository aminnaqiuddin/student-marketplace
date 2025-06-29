<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Logo/Header -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-uitm-purple">UniTrade</h1>
            <p class="mt-2 text-gray-600">Login to your account</p>
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
            <x-text-input
                id="email"
                class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
            <x-text-input
                id="password"
                class="block mt-1 w-full border-gray-300 focus:border-uitm-purple focus:ring-uitm-purple"
                type="password"
                name="password"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-uitm-purple shadow-sm focus:ring-uitm-purple"
                    name="remember"
                >
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-uitm-purple hover:text-uitm-purple-dark underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-uitm-purple border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-uitm-purple-dark focus:bg-uitm-purple-dark active:bg-uitm-purple-dark focus:outline-none focus:ring-2 focus:ring-uitm-gold focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Log in') }}
            </button>
        </div>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-uitm-purple hover:text-uitm-purple-dark underline">
                    {{ __('Register') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
