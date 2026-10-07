@props(['files' => []])
@php
    $files = collect($files)->filter()->values();
    $isImage = fn ($name) => in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    $images = $files->filter($isImage)->values();
    $others = $files->reject($isImage)->values();
    $url = fn ($name) => asset('storage/documents/' . $name);
@endphp

<div {{ $attributes->merge(['class' => 'mt-2']) }}
     x-data="{ open: null, images: @js($images->map($url)->all()) }"
     @keydown.escape.window="open = null"
     @keydown.arrow-right.window="if (open !== null) open = (open + 1) % images.length"
     @keydown.arrow-left.window="if (open !== null) open = (open + images.length - 1) % images.length">

    @if ($files->isEmpty())
        <p class="rq-value text-ink-mute">{{ __('No attachment.') }}</p>
    @endif

    @if ($images->isNotEmpty())
        <ul class="flex flex-wrap gap-3">
            @foreach ($images as $i => $name)
                <li>
                    <button type="button" @click="open = {{ $i }}"
                            class="group relative block h-28 w-28 overflow-hidden rounded-xl border border-line bg-canvas focus-visible:ring-2 focus-visible:ring-brand-cyan"
                            aria-label="{{ __('View :name', ['name' => $name]) }}">
                        <img src="{{ $url($name) }}" alt="" loading="lazy"
                             class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105">
                    </button>
                </li>
            @endforeach
        </ul>
    @endif

    @if ($others->isNotEmpty())
        <ul class="mt-3 divide-y divide-line rounded-xl border border-line">
            @foreach ($others as $name)
                <li class="flex items-center gap-3 px-3 py-2.5 text-sm">
                    <svg class="h-5 w-5 shrink-0 text-brand-dark" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <a href="{{ $url($name) }}" target="_blank" rel="noopener" class="min-w-0 flex-1 truncate text-ink hover:text-brand-dark hover:underline">{{ $name }}</a>
                    <a href="{{ $url($name) }}" download class="font-medium text-brand-dark hover:underline">{{ __('Download') }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Full-size viewer for images, moved to <body> so it covers the sidebar too --}}
    <template x-teleport="body">
    <template x-if="open !== null">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-navy-900/85 p-4 sm:p-10" @click.self="open = null"
             role="dialog" aria-modal="true" aria-label="{{ __('Image preview') }}">
            <img :src="images[open]" alt="" class="max-h-full max-w-full rounded-lg shadow-2xl">
            <div class="absolute right-4 top-4 flex gap-2">
                <a :href="images[open]" download class="rounded-lg bg-white/10 px-3 py-2 text-sm font-medium text-white hover:bg-white/20">{{ __('Download') }}</a>
                <button type="button" @click="open = null" class="rounded-lg bg-white/10 px-3 py-2 text-sm font-medium text-white hover:bg-white/20">{{ __('Close') }}</button>
            </div>
            <template x-if="images.length > 1">
                <p class="absolute bottom-4 text-sm text-slate-300" x-text="(open + 1) + ' / ' + images.length"></p>
            </template>
        </div>
    </template>
    </template>
</div>
