<x-guest-layout>
    <h1 class="text-2xl font-semibold text-ink">{{ __('Reset your password') }}</h1>
    <p class="mt-1 text-sm text-ink-mute">{{ __('Enter your work email. If it has an account, we will send a link to choose a new password.') }}</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full py-3">{{ __('Send reset link') }}</x-primary-button>
        <a href="{{ route('login') }}" class="block text-center text-sm font-medium text-brand-dark hover:underline">{{ __('Back to sign in') }}</a>
    </form>
</x-guest-layout>
