<div class="mt-10 w-full relative">
    <input id="search-bar" name="search" pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Please enter only characters')" onchange="this.setCustomValidity('')" value="{{ request()->get('search') }}" placeholder="Search for a user by name" class="block w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer pl-8 pr-2" required>
    <x-input-error :messages="$errors->get('search')" class="mt-2" />
    <button type="submit" class="absolute top-0 right-0 mt-3 mr-3 hover:text-my-light-blue">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
    </button>
</div>
<div class="mt-2">
    <a href="{{route('user-management.index')}}" class="text-my-blue ">All users</a>
</div>
