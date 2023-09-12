<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="flex-grow bg-white shadow-lg p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('LIST OF REQUESTS') }}</h1>
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
                                <th class="px-4 py-2">{{ __('ID') }}</th>
                                <th class="px-4 py-2">{{ __('FULL NAME') }}</th>
                                <th class="px-4 py-2">{{ __('TITLE') }}</th>
                                <th class="px-4 py-2">{{ __('STATUS') }}</th>
                                <th class="px-4 py-2">{{ __('ACTIONS') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $item)
                            <tr class="hover:bg-gray-200 border-b">
                                <td class="px-4 py-2">{{ $item->id }}</td>
                                <td class="px-4 py-2">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                <td class="px-4 py-2">{{ $item->title }}</td>
                                <td>
                                    {{ StatusHelper::print($item->status) }}
                                </td>
                                <td class=" px-4 -2">
                                    <x-secondary-link href="{{ route('document-management.show', $item->id) }}">{{ __('View') }}</x-secondary-link>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-my-blue text-center py-5">
                                    {{ __('No Documents Requests') }}
                                </td>
                            </tr>
                            @endforelse
                            <!-- Pagination links -->
                            <tr>
                                <td colspan="6" class="px-4 py-2">
                                    {{ $documents->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>