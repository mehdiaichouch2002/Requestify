<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side2 />
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
                <form method="post" action="{{ route('vacation-request.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col whitespace-nowrap md:flex-row justify-between items-center mb-5">
                        <x-title class="md:mr-4">{{ __('Request leave') }}</x-title>
                        <div class="md:flex items-center mt-4 md:mt-0">
                            <x-secondary-button type="submit">{{ __('Send request') }}</x-secondary-button>
                        </div>
                    </div>
                    <div class="grid  md:grid-cols-2 md:gap-12">
                        <div class="relative z-0 w-full mb-6 group">
                            <div class="relative z-0 w-full my-10 group">
                                <input type="text" name="title" id="title"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="title"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('Title') }}</label>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div class="relative w-full my-10 group">
                                <label for="description"
                                    class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Description') }}</label>
                                <textarea name="description" rows="5" placeholder="{{ __('A short reason helps HR decide faster') }}"
                                    class="focus:shadow-soft-primary-outline min-h-unset text-sm leading-5.6 ease-soft block h-auto w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all resize-none placeholder:text-gray-500 focus:border-my-light-blue focus:outline-none"
                                    required></textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <label for="attached_file"
                                class="block mb-3 text-sm font-medium text-gray-700 dark:text-gray-400">{{ __('Attachment') }}</label>
                            <label
                                class="flex justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none"
                                id="file_drop_area">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <span class="font-medium text-gray-600">
                                        Drop a file here, or
                                        <span class="text-blue-600 underline">browse</span>
                                    </span>
                                </span>
                                <input id="file_upload" type="file" name="attached_file" class="hidden">
                            </label>
                            <x-input-error :messages="$errors->get('attached_file')" class="mt-2" />
                            <ul id="file_list" class="mt-4"></ul>
                            <div class="flex-grow"></div>
                        </div>
                        <div class="max-w-xl flex flex-col">
                            <div class="relative z-0 w-full my-10 group">
                                <input type="date" name="from" id="from"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="date"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('First day') }}</label>
                                <x-input-error :messages="$errors->get('from')" class="mt-2" />
                            </div>
                            <div class="relative z-0 w-full mt-10 group">
                                <input type="date" name="to" id="to"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="date"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('Last day') }}</label>
                                <x-input-error :messages="$errors->get('to')" class="mt-2" />
                            </div>
                            <div class="relative z-0 w-full mt-20 group">
                                <label
                                    class="switch text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    {{ __('Paid leave') }}
                                    <input type="checkbox" id="paid" name="paid"
                                        class="absolute top-0 right-0 mr-2" />
                                    <div
                                        class="block  px-0 w-full text-gray-500 border-0 border-b dark:text-gray-400 border-gray-300 dark:border-gray-600">
                                        <span class="slider round"></span>
                                    </div>
                                </label>
                            </div>
                            <div id="status" class="mt-8 flex items-start gap-3 rounded-xl bg-canvas px-4 py-3 text-sm text-ink-soft">
                                <x-status :value="0" />
                                <span>{{ __('Your request starts as pending. You will get an email when HR accepts or rejects it.') }}</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('file_upload');
        const fileList = document.getElementById('file_list');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const listItem = document.createElement('li');
            listItem.textContent = file.name;
            fileList.innerHTML = '';
            fileList.appendChild(listItem);
        });
    </script>
</x-app-layout>
