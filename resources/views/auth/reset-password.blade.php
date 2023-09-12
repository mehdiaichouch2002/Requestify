<x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('password.store') }}" class="bg-cover px-6 py-4 bg-white shadow-md overflow-hidden mt-80px mb-100px rounded-lg">
        @csrf
        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="max-w-440px sm:rounded-lg pb-5 mt-11 px-50px">
            <div>
                <img src="{{ asset('/assets/img/logo.png') }}" alt="" class="w-9/12 m-auto px-11">
            </div>
            <div class="focus:ring-indigo-500 text-blue-400 p-8  text-center text-xl">
                <h1>Reset your password</h1>
            </div>

            <!-- Email Address -->
            <div class="arrondi-lg">
                <x-input-label for="email" class="mt-2 ml-14" :value="__('Email')" />
                <x-text-input id="email" class="block w-4/5 ml-12" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-14" />
            </div>

            <div class="mt-4 arrondi-lg relative">
                <x-input-label class="mt-2 ml-14 mb-2" for="password" :value="__('Password')" />
                <div class="flex">
                    <x-text-input id="password" class="block w-4/5 ml-12"
                                  type="password"
                                  placeholder="password"
                                  name="password"
                                  required/>
                </div>
            </div>

            <div class="mt-4 arrondi-lg relative">
                <x-input-label class="mt-2 ml-14 mb-2" for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block w-4/5 ml-12"
                              type="password"
                              placeholder="confirm password"
                              name="password_confirmation"
                              required/>
                <button type="button" id="showPasswordButton" class="ml-14 mt-3 focus:outline-none hover:text-my-light-blue">
                    {{ __('Show Password') }}
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2 ml-14"/>
            </div>

            <div class="mt-8 arrondi-lg relative flex justify-center">
                <x-secondary-button class="text-xl px-8 py-3" type="submit">
                    {{ __('Submit') }}
                </x-secondary-button>
            </div>
        </div>
    </form>


    <script>
        const showPasswordButton = document.getElementById('showPasswordButton');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        showPasswordButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
                showPasswordButton.textContent = 'Hide Password';
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
                showPasswordButton.textContent = 'Show Password';
            }
        });
    </script>

</x-guest-layout>

