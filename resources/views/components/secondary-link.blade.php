<a {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-lg border border-line bg-white px-3.5 py-2 text-sm font-medium text-ink transition-colors hover:border-brand hover:text-brand-dark focus-visible:ring-2 focus-visible:ring-brand-cyan focus-visible:ring-offset-2 disabled:opacity-50']) }}>
    {{ $slot }}
</a>
