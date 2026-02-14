<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                name="password"
                                required autocomplete="new-password" />
                <button type="button"
                        class="absolute inset-y-0 end-0 flex items-center px-3 text-slate-500 hover:text-slate-700"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                        :aria-pressed="showPassword.toString()">
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.477a3 3 0 004.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 4.243A9.956 9.956 0 0112 4c4.477 0 8.268 2.943 9.542 7a9.992 9.992 0 01-4.046 5.197M6.61 6.61A9.988 9.988 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.238 0 2.429-.225 3.53-.637" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative mt-1">
                <x-text-input id="password_confirmation" class="block w-full pr-12"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password" />
                <button type="button"
                        class="absolute inset-y-0 end-0 flex items-center px-3 text-slate-500 hover:text-slate-700"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                        :aria-pressed="showPassword.toString()">
                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.477 10.477a3 3 0 004.243 4.243" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 4.243A9.956 9.956 0 0112 4c4.477 0 8.268 2.943 9.542 7a9.992 9.992 0 01-4.046 5.197M6.61 6.61A9.988 9.988 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.238 0 2.429-.225 3.53-.637" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-slate-600 hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-white" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
