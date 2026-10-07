<x-guest-layout>
    <h1 class="text-2xl font-semibold text-ink">{{ __('Sign in') }}</h1>
    <p class="mt-1 text-sm text-ink-mute">{{ __('Use the email your HR team registered for you.') }}</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5" x-data="{ show: false }">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand-dark hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot it?') }}
                    </a>
                @endif
            </div>
            <div class="relative mt-1.5">
                <x-text-input id="password" class="block w-full pr-16" x-bind:type="show ? 'text' : 'password'" type="password"
                              name="password" required autocomplete="current-password" />
                <button type="button" @click="show = !show" aria-controls="password"
                        class="absolute inset-y-0 right-0 px-3 text-sm font-medium text-ink-mute hover:text-ink">
                    <span x-show="!show">{{ __('Show') }}</span>
                    <span x-show="show" style="display: none">{{ __('Hide') }}</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm text-ink-soft">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-line text-brand focus:ring-brand/30">
            {{ __('Keep me signed in') }}
        </label>

        <x-primary-button class="w-full py-3">{{ __('Sign in') }}</x-primary-button>
    </form>
</x-guest-layout>
