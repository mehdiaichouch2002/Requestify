@php
    $user = auth()->user();
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? __('Good morning') : ($hour < 18 ? __('Good afternoon') : __('Good evening'));
@endphp

<header class="flex items-center justify-between gap-4 px-6 pt-6 lg:pl-6 lg:pr-10">
    <div class="flex items-center gap-3">
        <button type="button" @click="$dispatch('toggle-sidebar')"
                class="-ml-2 rounded-lg p-2 text-ink-soft hover:bg-white lg:hidden" aria-label="{{ __('Open menu') }}">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div>
            <p class="font-display text-base font-semibold text-ink">{{ $greeting }}, {{ $user->firstname }}</p>
            <p class="text-sm text-ink-mute">{{ now()->format('l j F Y') }}</p>
        </div>
    </div>

    <x-dropdown>
        <x-slot name="trigger">
            <button class="flex items-center gap-3 rounded-full py-1 pl-1 pr-3 hover:bg-white" aria-label="{{ __('Account menu') }}">
                <img src="{{ $user->avatar ? asset('storage/photos/' . $user->avatar) : asset('assets/img/default-profile.jpg') }}"
                     alt="" class="h-9 w-9 rounded-full object-cover ring-2 ring-white">
                <span class="hidden text-left text-sm sm:block">
                    <span class="block font-medium text-ink">{{ $user->firstname }} {{ $user->lastname }}</span>
                    <span class="block text-xs text-ink-mute">{{ $user->job_title ?: ucfirst(str_replace('-', ' ', $user->role)) }}</span>
                </span>
            </button>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</header>

@if ($errors->has('status'))
    <div role="alert" class="mx-6 mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 lg:ml-6 lg:mr-10">
        {{ $errors->first('status') }}
    </div>
@endif
