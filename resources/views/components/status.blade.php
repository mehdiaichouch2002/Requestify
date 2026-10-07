@props(['value'])
@php
    // Full class names on purpose, so Tailwind keeps them in the build
    [$label, $class] = match ((int) $value) {
        1 => [__('Accepted'), 'rq-status rq-status--accepted'],
        2 => [__('Rejected'), 'rq-status rq-status--rejected'],
        default => [__('Pending'), 'rq-status rq-status--pending'],
    };
@endphp
<span {{ $attributes->merge(['class' => $class]) }}>{{ $label }}</span>
