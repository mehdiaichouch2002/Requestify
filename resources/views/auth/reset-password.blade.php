<x-guest-layout>
    <h1 class="text-2xl font-semibold text-ink">{{ __('Choose a new password') }}</h1>
    <p class="mt-1 text-sm text-ink-mute">{{ __('At least 8 characters.') }}</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-5" x-data="{ show: false }">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New password')" />
            <x-text-input id="password" class="mt-1.5 block w-full" x-bind:type="show ? 'text' : 'password'" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Repeat the new password')" />
            <x-text-input id="password_confirmation" class="mt-1.5 block w-full" x-bind:type="show ? 'text' : 'password'" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <label class="flex items-center gap-2 text-sm text-ink-soft">
            <input type="checkbox" x-model="show" class="rounded border-line text-brand focus:ring-brand/30">
            {{ __('Show passwords') }}
        </label>

        <x-primary-button class="w-full py-3">{{ __('Save new password') }}</x-primary-button>
    </form>
</x-guest-layout>
