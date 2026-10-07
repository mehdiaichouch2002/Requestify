@props(['accept', 'reject'])

<div class="mt-10 flex flex-wrap items-center justify-end gap-3 border-t border-line pt-6">
    <p class="mr-auto text-sm text-ink-mute">{{ __('The collaborator is emailed when you decide.') }}</p>
    <form method="POST" action="{{ $reject }}">
        @csrf
        @method('PATCH')
        <x-danger-button>{{ __('Reject') }}</x-danger-button>
    </form>
    <form method="POST" action="{{ $accept }}">
        @csrf
        @method('PATCH')
        <x-primary-button>{{ __('Accept') }}</x-primary-button>
    </form>
</div>
