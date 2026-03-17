@props([
    'status',
])

@if ($status)
    <div
        class="{{ ($frontendTemplate ?? 'default') === 'shadcn' ? 'rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700' : 'rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700' }}"
    >
        {{ $status }}
    </div>
@endif
