@php
    $person = fn ($r) => $r->user ? $r->user->firstname . ' ' . $r->user->lastname : __('Former employee');
    $queue = collect()
        ->merge($vacationPendings->map(fn ($r) => ['kind' => 'leave', 'who' => $person($r), 'what' => $r->title, 'at' => $r->created_at, 'url' => route('vacation-management.show', $r->id)]))
        ->merge($homeworkPendings->map(fn ($r) => ['kind' => 'remote', 'who' => $person($r), 'what' => $r->is_lifetime ? __('Permanent remote work') : \Illuminate\Support\Str::limit($r->description, 60), 'at' => $r->created_at, 'url' => route('homework-management.show', $r->id)]))
        ->merge($documentPendings->map(fn ($r) => ['kind' => 'document', 'who' => $person($r), 'what' => ucfirst($r->type), 'at' => $r->created_at, 'url' => route('document-management.show', $r->id)]))
        ->merge($materialPendings->map(fn ($r) => ['kind' => 'equipment', 'who' => $person($r), 'what' => $r->title, 'at' => $r->created_at, 'url' => route('material-management.show', $r->id)]))
        ->merge($evaluationPendings->map(fn ($r) => ['kind' => 'evaluation', 'who' => $person($r), 'what' => $r->title, 'at' => $r->created_at, 'url' => route('evaluation-management.show', $r->id)]))
        ->sortBy('at')
        ->values();
    $oldest = $queue->first();
@endphp
<x-app-layout>
    <div class="flex h-screen flex-row">
        <x-side />
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-ink sm:text-[1.75rem]">{{ __('Waiting for a decision') }}</h1>
                        <p class="mt-1 text-sm text-ink-mute">
                            @if ($queue->isEmpty())
                                {{ __('Nothing is waiting. New requests appear here as soon as they are sent.') }}
                            @else
                                {{ trans_choice(':count request, oldest first.|:count requests, oldest first.', $queue->count()) }}
                                {{ __('The oldest was sent :time.', ['time' => $oldest['at']->diffForHumans()]) }}
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('admin-history') }}" class="text-sm font-medium text-brand-dark hover:underline">{{ __('See all decisions') }}</a>
                </div>

                @if (session()->has('success'))
                    <x-success-alert :value="session()->get('success')" />
                @endif

                @if ($queue->isNotEmpty())
                    <ul class="mt-8 divide-y divide-line border-y border-line">
                        @foreach ($queue as $item)
                            <li>
                                <a href="{{ $item['url'] }}" class="group grid grid-cols-[auto_1fr_auto] items-center gap-x-4 gap-y-1 px-1 py-4 hover:bg-canvas/60 sm:grid-cols-[11rem_1fr_9rem_auto] sm:px-3">
                                    <x-request-kind :kind="$item['kind']" class="row-span-2 sm:row-span-1" />
                                    <span class="min-w-0">
                                        <span class="block truncate font-medium text-ink">{{ $item['who'] }}</span>
                                        <span class="block truncate text-sm text-ink-mute">{{ $item['what'] }}</span>
                                    </span>
                                    <span class="col-start-2 text-xs text-ink-mute sm:col-start-auto sm:text-sm">
                                        {{ __('Sent :time', ['time' => $item['at']->diffForHumans()]) }}
                                    </span>
                                    <span class="row-span-2 row-start-1 col-start-3 text-sm font-medium text-brand-dark group-hover:underline sm:col-start-auto sm:row-auto sm:row-span-1">
                                        {{ __('Review') }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="mt-16 flex flex-col items-center text-center">
                        <img src="{{ asset('favicon.svg') }}" alt="" class="h-14 w-14 opacity-90">
                        <p class="mt-4 font-display text-lg font-semibold text-ink">{{ __('Queue is clear') }}</p>
                        <p class="mt-1 max-w-sm text-sm text-ink-mute">{{ __('Every request has an answer. Collaborators were emailed each decision.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
