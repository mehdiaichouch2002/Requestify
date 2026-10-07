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
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
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
                            <x-field-label>{{ __('Name') }}</x-field-label>
                            <div
                                class="rq-value">
                                {{ $homework->user->firstname }} {{ $homework->user->lastname }}
                            </div>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-field-label>{{ __('Permanent') }}</x-field-label>
                        <div
                            class="rq-value">
                            {{ $homework->is_lifetime ? 'yes' : 'no' }}
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-1 mb-10 w-full">
                    <div class="relative z-0 w-full group">
                        <x-field-label>{{ __('Description') }}</x-field-label>
                        <div
                            class="rq-value">
                            {{ $homework->description }}
                        </div>
                    </div>
                </div>
                @if (!$homework->is_lifetime)
                    <div class="flex justify-between mb-6 items-center">
                        <div class="grid md:grid-cols-2 md:gap-6 w-full">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-field-label>{{ __('From') }}</x-field-label>
                                <div
                                    class="rq-value">
                                    {{ $homework->from_date ? $homework->from_date->format('Y-m-d') : '-' }}
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <x-field-label>{{ __('To') }}</x-field-label>
                                <div
                                    class="rq-value">
                                    {{ $homework->to_date ? $homework->to_date->format('Y-m-d') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between mb-6 items-center">
                        <div class="grid md:grid-cols-2 md:gap-6 w-full">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-field-label>{{ __('Duration') }}</x-field-label>
                                <div
                                    class="rq-value">
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
                            <x-field-label>{{ __('Status') }}</x-field-label>
                            <div
                                class="rq-value">
                                <p class="text-gray-900">
                                    <x-status :value="$homework->status" />
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                @if ($homework->status === 0)
                    <x-status-actions :accept="route('homework-management.accept', $homework->id)" :reject="route('homework-management.reject', $homework->id)" />
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
