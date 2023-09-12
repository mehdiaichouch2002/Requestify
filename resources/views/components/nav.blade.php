<div class="bg-white shadow-[rgba(13,_38,_76,_0.19)_0px_2px_6px] font-bold  ml-[40px] p-7 h-40px flex justify-between rounded  items-center">
    <div class="p-3 text-my-blue whitespace-nowrap">
        {{ now()->format('l, F j, Y') }}
    </div>
    <div>
            <x-dropdown>
                <x-slot name="trigger">
                    <button class="w-10 h-10 mt-1">
                        <img src="{{ isset(auth()->user()->avatar) ? asset('storage/photos/' . auth()->user()->avatar) : asset('assets/img/default-profile.jpg') }}" alt="User Avatar" class="w-full h-full rounded-full object-cover">
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
    </div>
</div>
