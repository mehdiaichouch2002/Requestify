<x-app-layout>
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="bg-white rounded-lg p-6 transform transition-all ease-out duration-300 max-w-md w-full">
            <h2 class="text-xl font-bold mb-4">{{ __('Confirm Delete') }}</h2>
            <p class="mb-4">{{ __('Are you sure you want to delete this document?') }}</p>
            <div class="flex justify-end">
                <x-secondary-button class="mr-2" id="cancelDelete">{{ __('Cancel') }}</x-secondary-button>
                <form action="{{ route('evaluation-management.destroy', $evaluation->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
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
                        <x-secondary-link href="{{ route('evaluation-management.index') }}"
                            class="mx-2">{{ __('Back') }}</x-secondary-link>
                        @if ($evaluation->status !== 0)
                            <x-danger-button id="deleteButton">{{ __('Delete') }}</x-danger-button>
                        @endif

                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-field-label>{{ __('Name') }}</x-field-label>
                                <div
                                    class="rq-value">
                                    {{ $evaluation->user->firstname }} {{ $evaluation->user->lastname }}
                                </div>
                            </div>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-field-label>{{ __('Title') }}</x-field-label>
                            <div
                                class="rq-value">
                                {{ $evaluation->title }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mb-6 items-center">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-field-label>{{ __('Day') }}</x-field-label>
                            <div
                                class="rq-value">
                                {{ date('l, d F Y', strtotime($evaluation->day)) }}
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <x-field-label>{{ __('Time') }}</x-field-label>
                            <div
                                class="rq-value">
                                {{ date('H:s', strtotime($evaluation->time)) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid md:grid-cols-1 mb-10 w-full">
                    <div class="relative z-0 w-full group">
                        <x-field-label>{{ __('Description') }}</x-field-label>
                        <div
                            class="rq-value">
                            {{ $evaluation->description }}
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mb-6 items-center">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-field-label>{{ __('Status') }}</x-field-label>
                            <div
                                class="rq-value">
                                <p class="text-gray-900">
                                    <x-status :value="$evaluation->status" />
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($evaluation->status === 0)
                    <x-status-actions :accept="route('evaluation-management.accept', $evaluation->id)" :reject="route('evaluation-management.reject', $evaluation->id)" />
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
        const deleteButton = document.getElementById('deleteButton');
        const deleteModal = document.getElementById('deleteModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const main = document.getElementById('main');

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
