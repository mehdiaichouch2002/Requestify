<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('LIST OF HOMEWORK') }}</h1>
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
                                <th class="px-4 py-2">{{ __('Collaborator') }}</th>
                                <th class="px-4 py-2">{{ __('FROM') }}</th>
                                <th class="px-4 py-2">{{ __('TO') }}</th>
                                <th class="px-4 py-2">{{ __('LIFE TIME') }}</th>
                                <th class="px-4 py-2">{{ __('STATUS') }}</th>
                                <th class="px-4 py-2">{{ __('ACTION') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr class="hover:bg-gray-200 border-b">
                                <td class="px-4 py-2">{{ $item->id }}</td>
                                <td class="px-4 py-2">{{ $item->user->firstname }} {{ $item->user->lastname }}</td>
                                <td class="px-4 py-2">
                                    {{ $item->from_date ? date('Y-m-d', strtotime($item->from_date)) : '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $item->to_date ? date('Y-m-d', strtotime($item->to_date)) : '-' }}
                                </td>
                                <td class="px-4 py-2">{{ $item->is_lifetime ? 'yes' : 'no' }}</td>
                                <td>
                                    {{ StatusHelper::print($item->status) }}
                                </td>
                                <td class="px-4 py-2 flex justify-center">
                                    <x-secondary-link href="{{ route('homework-management.show', $item->id) }}" class="mx-2">{{ __('View') }}</x-secondary-link>

                                    @empty
                            <tr>
                                <td colspan="6" class="text-my-red text-center py-5">No Users available!</td>
                            </tr>
                            @endforelse
                            <!-- Pagination links -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>