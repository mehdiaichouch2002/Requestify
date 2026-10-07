@php
    $mine = collect()
        ->merge($vacationPendings->map(fn ($r) => ['kind' => 'leave', 'what' => $r->title, 'r' => $r]))
        ->merge($homeworkPendings->map(fn ($r) => ['kind' => 'remote', 'what' => $r->is_lifetime ? __('Permanent remote work') : \Illuminate\Support\Str::limit($r->description, 60), 'r' => $r]))
        ->merge($documentPendings->map(fn ($r) => ['kind' => 'document', 'what' => $r->title, 'r' => $r]))
        ->merge($materialPendings->map(fn ($r) => ['kind' => 'equipment', 'what' => $r->title, 'r' => $r]))
        ->merge($evaluationPendings->map(fn ($r) => ['kind' => 'evaluation', 'what' => $r->title, 'r' => $r]))
        ->sortByDesc(fn ($i) => $i['r']->updated_at)
        ->values();

    $shortcuts = [
        ['leave', 'Leave', 'vacation-request.create'],
        ['remote', 'Remote work', 'homework-request.create'],
        ['document', 'A document', 'document-request.create'],
        ['equipment', 'Equipment', 'material-request.create'],
        ['evaluation', 'An evaluation', 'evaluation-request.create'],
    ];
@endphp
<x-app-layout>
    <div class="flex h-screen flex-row">
        <x-side2 />
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav />
            <div class="rq-panel">
                <h1 class="text-2xl font-semibold text-ink sm:text-[1.75rem]">{{ __('What do you need?') }}</h1>

                @if (session()->has('success'))
                    <x-success-alert :value="session()->get('success')" />
                @endif

                <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-5">
                    @foreach ($shortcuts as [$kind, $label, $route])
                        <a href="{{ route($route) }}"
                           class="group flex flex-col gap-3 rounded-xl border border-line px-4 py-4 transition-colors hover:border-brand hover:bg-brand-cyan/5">
                            <x-request-kind :kind="$kind" class="font-medium text-ink" />
                            <span class="text-xs text-ink-mute group-hover:text-brand-dark">{{ __('New request') }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12 flex items-end justify-between gap-4">
                    <div>
                        <h2 class="font-display text-lg font-semibold text-ink">{{ __('Your requests') }}</h2>
                        <p class="text-sm text-ink-mute">{{ __('Pending ones, and decisions from the last 7 days.') }}</p>
                    </div>
                    <a href="{{ route('collaborator-history') }}" class="text-sm font-medium text-brand-dark hover:underline">{{ __('Full history') }}</a>
                </div>

                @if ($mine->isEmpty())
                    <p class="mt-6 rounded-xl bg-canvas px-5 py-6 text-sm text-ink-soft">
                        {{ __('No open requests. Choose a type above to send one; you will be emailed when HR decides.') }}
                    </p>
                @else
                    <ul class="mt-4 divide-y divide-line border-y border-line">
                        @foreach ($mine as $item)
                            <li class="grid grid-cols-[1fr_auto] items-center gap-x-4 gap-y-1 px-1 py-4 sm:grid-cols-[11rem_1fr_9rem_auto] sm:px-3">
                                <x-request-kind :kind="$item['kind']" class="hidden sm:inline-flex" />
                                <span class="min-w-0">
                                    <span class="block truncate font-medium text-ink">{{ $item['what'] }}</span>
                                    <span class="block text-xs text-ink-mute sm:hidden">{{ __(['leave' => 'Leave', 'remote' => 'Remote work', 'document' => 'Document', 'equipment' => 'Equipment', 'evaluation' => 'Evaluation'][$item['kind']]) }}</span>
                                </span>
                                <span class="hidden text-sm text-ink-mute sm:block">
                                    {{ $item['r']->status == 0 ? __('Sent :time', ['time' => $item['r']->created_at->diffForHumans()]) : __('Decided :time', ['time' => $item['r']->updated_at->diffForHumans()]) }}
                                </span>
                                <x-status :value="$item['r']->status" />
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
