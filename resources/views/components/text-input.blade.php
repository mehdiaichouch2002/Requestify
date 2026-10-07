@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-lg border-line bg-white text-ink placeholder:text-ink-mute shadow-sm focus:border-brand focus:ring-brand/30']) !!}>
