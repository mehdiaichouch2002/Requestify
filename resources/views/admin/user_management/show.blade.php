<x-app-layout>
    <div class="flex bg-gray flex-row bg-gray h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <x-title>{{ __('USER PROFILE') }}</x-title>
                    <div class="flex items-center">
                        <x-secondary-link href="{{ url()->previous() }}"
                            class="mx-2">{{ __('Back') }}</x-secondary-link>
                        @if (auth()->user()->id !== $user->id && $user->role !== 'super-admin')
                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $user->id }}')"
                                data-item-id="{{ $user->id }}" class="mr-3">{{ __('Delete') }}</x-danger-button>
                        @endif
                    </div>
                </div>
                @if (session()->has('success'))
                    <div>
                        <x-success-alert :value="session()->get('success')" />
                    </div>
                @endif
                <div id="new" class="grid place-items-center mt-5">
                    <img src="{{ isset($user->avatar) ? asset('storage/photos/' . $user->avatar) : asset('assets/img/default-profile.jpg') }}"
                        alt="avatar" class="w-[125px] h-[125px] rounded-lg">
                    <x-title class="my-5 font-sans">{{ $user->firstname }} {{ $user->lastname }}</x-title>
                    <p class="text-sky-900 font-sans text-2xl">
                        {{ isset($user->job_title) ? $user->job_title : __('Unknown') }}
                        ({{ $user->role }})</p>
                </div>
                <div class="flex justify-between items-center my-5">
                    <hr class="border-t border-my-light-blue w-full my-5">
                </div>
                <div class="flex justify-between items-center mt-5">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <div class="relative z-0 w-full mb-6 group">
                                <x-title class="text-xl mb-5">{{ __('Email Adresse') }}</x-title>
                                <div
                                    class="block py-2.5 px-0 w-full text-sm border-0 border-b dark:border-my-light-blue">
                                    <div class="flex items-center">
                                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.3333 6.92053V18.0253C23.3333 20.3889 21.7508 22.3204 19.7568 22.451L19.5417 22.4579H3.79167C1.7698 22.4579 0.117542 20.6078 0.00599674 18.2768L0 18.0253V6.92053L11.2607 13.8169C11.515 13.9725 11.8183 13.9725 12.0727 13.8169L23.3333 6.92053ZM3.79167 0.635742H19.5417C21.5072 0.635742 23.1235 2.38412 23.3144 4.62313L11.6667 11.7559L0.0188884 4.62313C0.202837 2.46705 1.70837 0.765925 3.57477 0.642875L3.79167 0.635742Z"
                                                fill="#A8CBD6" />
                                        </svg>
                                        <span class="text-my-blue text-lg mx-3">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <x-title class="text-xl mb-5">{{ __('Phone Number') }}</x-title>
                            <div class="block py-2.5 px-0 w-full text-sm border-0 border-b dark:border-my-light-blue">
                                <div class="flex items-center">
                                    <svg width="14" height="29" viewBox="0 0 14 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.375 0.959473C12.8247 0.959473 14 2.3334 14 4.02822V25.1685C14 26.8632 12.8247 28.2372 11.375 28.2372H2.625C1.17525 28.2372 0 26.8632 0 25.1685V4.02822C0 2.3334 1.17525 0.959473 2.625 0.959473H11.375ZM8.45833 22.7817H5.54167C5.05843 22.7817 4.66667 23.2397 4.66667 23.8046C4.66667 24.3695 5.05843 24.8275 5.54167 24.8275H8.45833C8.94157 24.8275 9.33333 24.3695 9.33333 23.8046C9.33333 23.2397 8.94157 22.7817 8.45833 22.7817Z"
                                            fill="#A8CBD6" />
                                    </svg>
                                    <span class="text-my-blue text-lg mx-3">
                                        @if (isset($user->phone))
                                            {{ $user->phone }}
                                        @else
                                            {{ __('-') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-5">
                    <div class="grid md:grid-cols-2 md:gap-6 w-full">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-title class="text-xl mb-5">{{ __('Date of Birth') }}</x-title>
                            <div class="block py-2.5 px-0 w-full text-sm border-0 border-b dark:border-my-light-blue">
                                <div class="flex items-center">
                                    <svg width="23" height="29" viewBox="0 0 23 29" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21.4667 7.92101H1.53333V6.16744C1.53333 5.19947 2.22027 4.41388 3.06667 4.41388H6.13333V5.29066C6.13333 5.77552 6.47603 6.16744 6.9 6.16744C7.32397 6.16744 7.66667 5.77552 7.66667 5.29066V4.41388H15.3333V5.29066C15.3333 5.77552 15.676 6.16744 16.1 6.16744C16.524 6.16744 16.8667 5.77552 16.8667 5.29066V4.41388H19.9333C20.7797 4.41388 21.4667 5.19947 21.4667 6.16744V7.92101ZM19.9333 16.6889C19.9333 17.6568 19.2464 18.4424 18.4 18.4424H16.8667C16.0203 18.4424 15.3333 17.6568 15.3333 16.6889V14.9353C15.3333 13.9673 16.0203 13.1817 16.8667 13.1817H18.4C19.2464 13.1817 19.9333 13.9673 19.9333 14.9353V16.6889ZM19.9333 23.7031C19.9333 24.6711 19.2464 25.4567 18.4 25.4567H16.8667C16.0203 25.4567 15.3333 24.6711 15.3333 23.7031V21.9496C15.3333 20.9816 16.0203 20.196 16.8667 20.196H18.4C19.2464 20.196 19.9333 20.9816 19.9333 21.9496V23.7031ZM13.8 16.6889C13.8 17.6568 13.1131 18.4424 12.2667 18.4424H10.7333C9.88693 18.4424 9.2 17.6568 9.2 16.6889V14.9353C9.2 13.9673 9.88693 13.1817 10.7333 13.1817H12.2667C13.1131 13.1817 13.8 13.9673 13.8 14.9353V16.6889ZM13.8 23.7031C13.8 24.6711 13.1131 25.4567 12.2667 25.4567H10.7333C9.88693 25.4567 9.2 24.6711 9.2 23.7031V21.9496C9.2 20.9816 9.88693 20.196 10.7333 20.196H12.2667C13.1131 20.196 13.8 20.9816 13.8 21.9496V23.7031ZM7.66667 16.6889C7.66667 17.6568 6.97973 18.4424 6.13333 18.4424H4.6C3.7536 18.4424 3.06667 17.6568 3.06667 16.6889V14.9353C3.06667 13.9673 3.7536 13.1817 4.6 13.1817H6.13333C6.97973 13.1817 7.66667 13.9673 7.66667 14.9353V16.6889ZM7.66667 23.7031C7.66667 24.6711 6.97973 25.4567 6.13333 25.4567H4.6C3.7536 25.4567 3.06667 24.6711 3.06667 23.7031V21.9496C3.06667 20.9816 3.7536 20.196 4.6 20.196H6.13333C6.97973 20.196 7.66667 20.9816 7.66667 21.9496V23.7031ZM19.9333 2.66031H16.8667V1.78352C16.8667 1.29954 16.524 0.906738 16.1 0.906738C15.676 0.906738 15.3333 1.29954 15.3333 1.78352V2.66031H7.66667V1.78352C7.66667 1.29954 7.32397 0.906738 6.9 0.906738C6.47603 0.906738 6.13333 1.29954 6.13333 1.78352V2.66031H3.06667C1.3731 2.66031 0 4.23063 0 6.16744V25.4567C0 27.3935 1.3731 28.9638 3.06667 28.9638H19.9333C21.6269 28.9638 23 27.3935 23 25.4567V6.16744C23 4.23063 21.6269 2.66031 19.9333 2.66031Z"
                                            fill="#A8CBD6" />
                                    </svg>
                                    <span class="text-my-blue text-lg mx-3">
                                        @if (isset($user->dob))
                                            {{ date('d F Y', strtotime($user->dob)) }} -
                                            {{ date_diff(date_create($user->dob), date_create(date('Y-m-d')))->y . __(' years old') }}
                                        @else
                                            {{ __('-') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if (auth()->user()->id !== $user->id && $user->role !== 'super-admin')
                        <div class="relative z-0 w-full mb-6 group">
                            <x-title class="text-xl mb-5">{{ __('Change Role') }}</x-title>
                            <form method="post" action="{{ route('user-management.update', $user->id) }}"
                                class="flex" id="role-form">
                                @csrf
                                @method('patch')
                                <select name="role"
                                    class="block mr-5 py-3.5 mb-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b appearance-none dark:text-black dark:border-my-light-blue dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    required>
                                    <option value="collaborator" {{ $user->role == 'collaborator' ? 'selected' : '' }}>
                                        Collaborator</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                <div class="mt-4">
                                    <x-secondary-button type="submit" id="save-button"
                                        disabled>{{ __('SAVE') }}</x-secondary-button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <x-modal name="confirm-user-deletion-{{ $user->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user-management.destroy', $user->id) }}">
            @csrf
            @method('DELETE')
            <div class="m-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete : ') }} <b class="text-red-500">{{ $user->firstname }}
                        {{ $user->lastname }}</b> ?
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
    <script>
        // Get the initial selected value
        var initialRole = document.querySelector('#role-form select[name="role"]').value;

        // Add an event listener to the select element
        document.querySelector('#role-form select[name="role"]').addEventListener('change', function(event) {
            // Get the current selected value
            var currentRole = event.target.value;
            // Check if the current value is different from the initial value
            if (currentRole !== initialRole) {
                // Enable the save button
                document.querySelector('#save-button').disabled = false;
            } else {
                // Disable the save button
                document.querySelector('#save-button').disabled = true;
            }
        });
    </script>
</x-app-layout>
