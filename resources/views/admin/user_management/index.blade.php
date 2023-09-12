<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />

        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('LIST OF USERS') }}</h1>
                    <div class="flex items-center">
                        <button class="text-my-blue hover:text-my-light-blue" id="search-button">
                            <svg class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                        <x-secondary-link href="{{ route('user-management.create') }}" class="mx-12">{{ __('ADD USER') }}</x-secondary-link>
                    </div>

                </div>
                <div id="search-bar-container" class="w-[96%]">
                    <form method="get" action="{{ route('user-management.index') }}">
                        <x-search-bar />
                    </form>
                </div>
                @if (session()->has('success'))
                <div class="w-[96%]">
                    <x-success-alert :value="session()->get('success')" />
                </div>
                @endif

                <div class="grid mt-9">
                    <table class="w-full mt-9 pr-5 text-left text-black whitespace-nowrap">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">FIRST NAME</th>
                                <th class="px-4 py-2">LAST NAME</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr class="hover:bg-gray-200 border-b">
                                <td class="px-4 py-2">{{ $item->id }}</td>
                                <td class="px-4 py-2">{{ $item->firstname }}</td>
                                <td class="px-4 py-2">{{ $item->lastname }}</td>
                                <td class="px-4 py-2">{{ $item->role }}</td>
                                <td class="px-4 py-2">{{ $item->email }}</td>
                                <td class="px-4 py-2 flex items-center">
                                    <x-secondary-link href="{{ route('user-management.show', $item->id) }}" class="mx-2">{{ __('More info') }}</x-secondary-link>
                                    @if (auth()->user()->id !== $item->id)
                                    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $item->id }}')" data-item-id="{{ $item->id }}">{{ __('Delete Account') }}</x-danger-button>
                                    @else
                                    <h3 class="text-my-green mx-5 mt-1 ">(You)</h3>
                                    @endif
                                </td>
                            </tr>
                            <x-modal name="confirm-user-deletion-{{ $item->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('user-management.destroy', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="m-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Are you sure you want to delete ID : ') }} <b class="text-red-500">{{ $item->firstname }}
                                                {{ $item->lastname }}</b> ?
                                        </h2>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                        </p>
                                    </div>
                                    <div class="m-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="ml-3 ">
                                            {{ __('Delete Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                            @empty
                            <tr>
                                <td colspan="6" class="text-my-blue text-center py-5">No Users available!</td>
                            </tr>
                            @endforelse
                            <!-- Pagination links -->
                            <tr>
                                <td colspan="6" class="px-4 py-2">
                                    {{ $data->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchButton = document.getElementById('search-button');
            var searchBarContainer = document.getElementById('search-bar-container');

            searchButton.addEventListener('click', function() {
                searchBarContainer.classList.toggle('hidden');
                if (searchBarContainer.classList.contains('hidden')) {
                    searchButton.innerHTML =
                        '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/></svg><span class="sr-only">Search</span>';
                } else {
                    searchButton.innerHTML =
                        '<svg class="h-5 w-5"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>'
                }
            });
        });
    </script>
</x-app-layout>