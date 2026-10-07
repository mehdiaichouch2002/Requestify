@props(['type' => 'button'])
{{-- Used both as the main "send" action in forms (type=submit) and as a cancel button --}}
<button type="{{ $type }}" {{ $attributes->merge(['class' => $type === 'submit' ? 'inline-flex items-center justify-center gap-2 rounded-lg bg-navy px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-navy-700 focus-visible:ring-2 focus-visible:ring-brand-cyan focus-visible:ring-offset-2 disabled:opacity-50' : 'inline-flex items-center justify-center gap-2 rounded-lg border border-line bg-white px-3.5 py-2 text-sm font-medium text-ink transition-colors hover:border-brand hover:text-brand-dark focus-visible:ring-2 focus-visible:ring-brand-cyan focus-visible:ring-offset-2 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
