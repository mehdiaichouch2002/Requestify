<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('Leave requests') }}</h1>
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
                                <th class="px-4 py-2">{{ __('#') }}</th>
                                <th class="px-4 py-2">{{ __('Collaborator') }}</th>
                                <th class="px-4 py-2">{{ __('From') }}</th>
                                <th class="px-4 py-2">{{ __('To') }}</th>
                                <th class="px-4 py-2">{{ __('Duration') }}</th>
                                <th class="px-4 py-2">{{ __('Status') }}</th>
                                <th class="px-4 py-2">{{ __('') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr class="hover:bg-gray-200 border-b">
                                <td class="px-4 py-2">{{ $item->id }}</td>
                                <td class="px-4 py-2">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                <td class="px-4 py-2">{{ date('Y-m-d', strtotime($item->from)) }}</td>
                                <td class="px-4 py-2">{{ date('Y-m-d', strtotime($item->to)) }}</td>
                                <td class="px-4 py-2">
                                    @php
                                    $from = strtotime($item->from);
                                    $to = strtotime($item->to);
                                    $duration = $to - $from;
                                    $days = floor($duration / (60 * 60 * 24));
                                    @endphp
                                    {{ $days }}{{ $days > 1 ? ' days' : __(' day') }}
                                </td>

                                <td>
                                    <x-status :value="$item->status" />
                                </td>

                                <td class="py-2 flex items-center">
                                    <x-secondary-link href="{{ route('vacation-management.show', $item->id) }}" class="mx-2">{{ __('View') }}</x-secondary-link>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-my-blue text-center py-5">No vacation Request found!</td>
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