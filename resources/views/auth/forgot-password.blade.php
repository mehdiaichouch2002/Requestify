<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form method="POST" action="{{ route('password.email') }}"
          class="bg-cover px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg"
    >
        @csrf
        <div class="max-w-440px sm:rounded-lg mx-auto my-11 px-4 sm:px-6 lg:px-8">
            <div>
                <img src="{{ asset('/assets/img/logo.png')}}" alt="" class="w-9/12 mx-auto ">
            </div>
            <div class="focus:ring-indigo-500 text-blue-400 p-8  text-center text-xl">
                <h1>Reset your password</h1>
            </div>
            <!-- Email Address -->
            <div>
                <x-input-label class="ml-4 mb-2" for="email" :value="__('Email')"/>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                              required
                            placeholder="{{ __('Enter your email') }}"  autofocus/>
                <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4"/>
            </div>

            <div class="flex items-center justify-center mt-5">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
            <div class="mb-4 text-sm text-center mt-5 text-gray-600">
                {{ __('If your email exists,We will send you a password reset link.') }}
            </div>
        </div>
    </form>
</x-guest-layout>
