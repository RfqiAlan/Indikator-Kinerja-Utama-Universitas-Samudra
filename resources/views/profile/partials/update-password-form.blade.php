<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_current_password" name="current_password" x-bind:type="showPassword ? 'text' : 'password'" class="block w-full pr-12" autocomplete="current-password" />
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
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password" name="password" x-bind:type="showPassword ? 'text' : 'password'" class="block w-full pr-12" autocomplete="new-password" />
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
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="showPassword ? 'text' : 'password'" class="block w-full pr-12" autocomplete="new-password" />
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
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
