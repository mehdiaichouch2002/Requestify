<section>

    <header>
        <h2 class="text-lg font-medium text-my-blue ">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-my-blue ">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 grid grid-cols-2 gap-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="firstname" :value="__('First Name')" />
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value="old('firstname', $user->firstname)" required autocomplete="firstname" />
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <div>
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)" required autocomplete="firstname" />
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <div>
            <x-input-label for="job_title" :value="__('Job Title')" />
            <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $user->job_title)" autocomplete="job_title" />
            <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
        </div>

        <div>
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-date-input id="dob" name="dob" class="mt-1 block w-full" :value="old('dob', date('Y-m-d', strtotime($user->dob)))"/>
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone (+212 6XXXXXXXX)')" />
            <x-text-input type="tel" pattern="^\+212\s[67]\d{8}$"  id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)"  autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>



        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-my-blue 0">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-my-blue hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-my-green">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <x-file-input  type="file" id="avatar" accept="image/*" name="avatar" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="col-span-2 flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-my-blue "
                >{{ __('Saved.') }}</p>
            @endif
        </div>
        </form>
</section>
