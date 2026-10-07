<a {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-lg bg-navy px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-navy-700 focus-visible:ring-2 focus-visible:ring-brand-cyan focus-visible:ring-offset-2 disabled:opacity-50']) }}>
    {{ $slot }}
</a>
