<x-app-layout>
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="bg-white rounded-lg p-6 transform transition-all ease-out duration-300 max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">{{ __('Confirm Delete') }}</h2>
            <p class="mb-4">{{ __('Are you sure you want to delete this document?') }}</p>
            <div class="flex justify-end">
                <x-secondary-button class="mr-2" id="cancelDelete">{{ __('Cancel') }}</x-secondary-button>
                <form action="{{ route('homework-management.destroy', $homework->id) }}" method="POST">
                    @csrf
                    @method('DELETE').
                    <x-danger-button type="submit">{{ __('Delete') }}</x-danger-button>
                </form>
            </div>
        </div>
    </div>

    <div id="main" class="flex bg-gray flex-row bg-gray h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between mb-10 items-center">
                    <x-title>{{ __('Request details') }}</x-title>
                    <div class="flex items-center">
                        <x-secondary-link href="{{ url()->previous() }}"
                            class="mx-2">{{ __('Back') }}</x-secondary-link>
                        @if ($homework->status !== 0)
                            <x-danger-button id="deleteButton">{{ __('Delete') }}</x-danger-button>
                        @endif

                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 w-full">
                    <div class="relative z-0 w-full mb-6 group">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-title class="text-xl">{{ __('Full Name') }}</x-title>
                            <div
                                class="block py-2.5 px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                                {{ $homework->user->firstname }} {{ $homework->user->lastname }}
                            </div>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-title class="text-xl ">{{ __('Is_Lifetime') }}</x-title>
                        <div
                            class="block py-2.5 font-bold px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                            {{ $homework->is_lifetime ? 'yes' : 'no' }}
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-1 mb-10 w-full">
                    <div class="relative z-0 w-full group">
                        <x-title class="text-xl">{{ __('Description') }}</x-title>
                        <div
                            class="py-2.5 font-bold px-0 w-full text-sm text-sky-800 border-0 border-b dark:border-my-light-blue break-words whitespace-normal">
                            {{ $homework->description }}
                        </div>
                    </div>
                </div>
                @if (!$homework->is_lifetime)
                    <div class="flex justify-between mb-6 items-center">
                        <div class="grid md:grid-cols-2 md:gap-6 w-full">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-title class="text-xl ">{{ __('FROM') }}</x-title>
                                <div
                                    class="block py-2.5 font-bold px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                                    {{ $homework->from_date ? $homework->from_date->format('Y-m-d') : '-' }}
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <x-title class="text-xl ">{{ __('To') }}</x-title>
                                <div
                                    class="block py-2.5 font-bold px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                                    {{ $homework->to_date ? $homework->to_date->format('Y-m-d') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mb-6 items-center">
                        <div class="grid md:grid-cols-2 md:gap-6 w-full">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-title class="text-xl ">{{ __('Duration') }}</x-title>
                                <div
                                    class="block py-2.5 font-bold px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                                    @php
                                        $from = strtotime($homework->from_date);
                                        $to = strtotime($homework->to_date);
                                        $duration = $to - $from;
                                        $days = (floor($duration / (60 * 60 * 24))) + 1;
                                    @endphp
                                    {{ $days }}{{ $days > 1 ? __(' days') : __(' day') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex justify-between mb-6 items-center">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-title class="text-xl">{{ __('Status') }}</x-title>
                            <div
                                class="block py-2.5 px-0 w-full text-base text-sky-800 border-0 border-b dark:border-my-light-blue">
                                <p class="text-gray-900">
                                    @if ($homework->status == 0)
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-base text-yellow-500 px-3.5 py-1.5 rounded-lg">
                                            {{ __('Pending') }}
                                        </span>
                                    @elseif ($homework->status == 1)
                                        <span
                                            class="bg-my-light-green text-my-green text-base text-my-green px-3.5 py-1.5 rounded-lg ">{{ __('Accepted') }}
                                        </span>
                                    @elseif ($homework->status == 2)
                                        <span
                                            class="bg-my-light-red  text-my-red text-base text-my-red px-3.5 py-1.5 rounded-lg">
                                            {{ __('Rejected') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                @if ($homework->status === 0)
                    <div class="flex mt-10 justify-end">
                        <x-success-link href="{{ route('homework-management.accept', $homework->id) }}"
                            class="mr-1">{{ __('Accept') }}</x-success-link>
                        <x-danger-link
                            href="{{ route('homework-management.reject', $homework->id) }}">{{ __('Reject') }}</x-danger-link>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
    <style>
        /* Adjust page opacity when modal is displayed */
        #main.modal-open {
            opacity: 0.3;
        }

        /* Modal animation */
        #deleteModal {
            transition-property: opacity, transform;
            transition-duration: 300ms;
            transition-timing-function: ease-out;
        }

        #deleteModal.open {
            opacity: 1;
            pointer-events: auto;
            transform: translate(0%, -30%);
        }
    </style>

    <script>
        const deleteButton = homework.getElementById('deleteButton');
        const deleteModal = homework.getElementById('deleteModal');
        const cancelDelete = homework.getElementById('cancelDelete');
        const main = homework.getElementById('main');

        deleteButton.addEventListener('click', () => {
            main.classList.add('modal-open');
            deleteModal.classList.add('open');
        });

        cancelDelete.addEventListener('click', () => {
            main.classList.remove('modal-open');
            deleteModal.classList.remove('open');
        });
    </script>
</x-app-layout>
