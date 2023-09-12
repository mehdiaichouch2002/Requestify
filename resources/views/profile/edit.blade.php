<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <x-secondary-link href="{{ url()->previous() !== url('/profile') ? url()->previous() : url('/') }}"
                              class="mx-2">{{__('BACK')}}</x-secondary-link>
            <a href="{{route('dashboard')}}">
          <img src="{{asset('assets/img/logo.png')}}" alt="" srcset="" class="float-right w-[90px] m-0 p-0">
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session()->has('status'))
                <x-success-alert :value="session()->get('status')"/>
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
