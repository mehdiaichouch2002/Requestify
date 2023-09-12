<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('LIST OF EVALUATIONS') }}</h1>
                </div>
                @if (session()->has('success'))
                <div class="w-[96%]">
                    <x-success-alert :value="session()->get('success')" />
                </div>
                @endif
                <div class="grid mt-9">
                    <table class="w-full mt-9 pr-5 text-center text-black whitespace-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="px-4 py-2">{{ __('COLLABORATOR') }}</th>
                                <th class="px-4 py-2">{{ __('DAY') }}</th>
                                <th class="px-4 py-2">{{ __('TIME') }}</th>
                                <th class="px-4 py-2">{{ __('STATUS') }}</th>
                                <th class="px-4 py-2">{{ __('ACTION') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($evaluations as $item)
                            <tr class="hover:bg-gray-200 border-b">
                                <td class="py-2">{{ $item->id }}</td>
                                <td class="py-2">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                <td class="py-2">{{ date('l, d F Y', strtotime($item->day)) }}</td>
                                <td class="py-2">{{ date('H:s', strtotime($item->time)) }}</td>
                                <td>
                                    {{ StatusHelper::print($item->status) }}
                                </td>
                                <td>
                                    <x-secondary-link href="{{ route('evaluation-management.show', $item->id) }}" class="mx-2">{{ __('View') }}</x-secondary-link>
                                    @empty
                            <tr>
                                <td colspan="6" class="text-my-blue text-center py-5">No Evaluations available.
                                </td>
                            </tr>
                            @endforelse
                            <!-- Pagination links -->

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