<a {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-lg border border-red-200 bg-white px-3.5 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-50 focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2']) }}>
    {{ $slot }}
</a>
