<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side2 />
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
                <form method="post" action="{{ route('evaluation-request.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex whitespace-nowrap flex-col md:flex-row justify-between items-center mb-5">
                        <x-title class="md:mr-4">{{ __('Request an evaluation') }}</x-title>
                        <div class="md:flex items-center mt-4 md:mt-0">
                            <x-secondary-button type="submit">{{ __('Send request') }}</x-secondary-button>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-12">
                        <div class="relative z-0 w-full mb-6 group">
                            <div class="relative z-0 w-full my-10 group">
                                <input type="title" name="title" id="title"
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
                        </div>
                        <div class="max-w-xl flex flex-col">
                            <div class="relative z-0 w-full my-10 group">
                                <input type="date" name="day" id="day"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <label for="day"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('Date') }}</label>
                                <x-input-error :messages="$errors->get('day')" class="mt-2" />
                            </div>
                            <div class="relative z-0 w-full my-10 group">
                                <input type="time" name="time" id="time"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required min="09:00" max="18:00" />
                                <label for="time"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{ __('Time') }}</label>
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
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

</x-app-layout>
