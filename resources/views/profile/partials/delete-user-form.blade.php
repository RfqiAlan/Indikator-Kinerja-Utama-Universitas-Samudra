<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-slate-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-slate-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6" x-data="{ showPassword: false }">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative mt-1 w-3/4">
                    <x-text-input
                        id="password"
                        name="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        class="block w-full pr-12"
                        placeholder="{{ __('Password') }}"
                    />
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

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
