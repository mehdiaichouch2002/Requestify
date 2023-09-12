<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('login') }}"
          class="bg-cover px-6 py-4 bg-white shadow-md overflow-hidden mt-80px mb-30px rounded-lg"
    >
        @csrf
        <div class="max-w-440px sm:rounded-lg m-auto mx-lo mt-11 px-50px">
            <div>
                <img src="{{ URL::to('/assets/img/logo.png')}}" alt="" class="w-9/12 m-auto px-11">
            </div>

            <div class="focus:ring-indigo-500 text-blue-400 pt-11 pb-8 pl-28 text-xl">
                <h1>Sign into your account</h1>
            </div>

            <!-- Email Address -->
            <div class="arrondi-lg mx-lo">
                <x-text-input id="email" class="block w-4/5 ml-12" placeholder="Email" name="email"
                              :value="old('email')" type="email" required autofocus autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-14"/>
            </div>

            <div class="mt-4 arrondi-lg relative">
                <x-text-input id="password" class="block w-4/5 ml-12"
                              type="password"
                              placeholder="password"
                              name="password"
                              required autocomplete="current-password"/>
                <button type="button" class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        onclick="togglePasswordVisibility()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3 5a6 6 0 100-12 6 6 0 000 12z"/>
                    </svg>
                </button>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 mx-12 flex justify-between">
                <div>
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-blue-400 shadow-sm focus:ring-teal-500"
                               name="remember">
                        <span class="ml-2 text-sm  text-blue-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end text-blue-400 ">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-400  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-300"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                </div>
            </div>
            @endif

            <x-primary-button
                class="ml-130px my-30px w-2/5 py-3 border border-transparent text-sm leading-4 font-medium rounded-lg text-blue-100 hover:text-white focus:outline-none transition ease-in-out duration-150">
                {{ __('Log in') }}

            </x-primary-button>
        </div>


    </form>
</x-guest-layout>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>
