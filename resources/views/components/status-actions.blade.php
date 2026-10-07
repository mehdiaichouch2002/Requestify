@props(['accept', 'reject'])

<div class="flex mt-10 justify-end">
    <form method="POST" action="{{ $accept }}" class="mr-1">
        @csrf
        @method('PATCH')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-my-light-green border border-gray-300 rounded-md font-semibold text-xs text-my-green uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Accept') }}</button>
    </form>
    <form method="POST" action="{{ $reject }}">
        @csrf
        @method('PATCH')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-my-light-red border border-transparent rounded-md uppercase font-semibold text-xs text-my-red tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">{{ __('Reject') }}</button>
    </form>
</div>
