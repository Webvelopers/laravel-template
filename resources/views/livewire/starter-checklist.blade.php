<section class="rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]">
    <div class="flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold tracking-[0.3em] text-amber-700 uppercase">
                {{ __('frontend.checklist.eyebrow') }}
            </p>
            <h2 class="font-display mt-2 text-2xl text-stone-950">{{ __('frontend.checklist.headline') }}</h2>
        </div>
        <span
            class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-semibold tracking-[0.24em] text-emerald-700 uppercase"
        >
            Livewire
        </span>
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2">
        @foreach ($checks as $check)
            <div
                class="{{ $check['ready'] ? 'border-emerald-200 bg-emerald-50/70' : 'border-amber-200 bg-amber-50/70' }} rounded-2xl border px-4 py-4"
            >
                <div class="flex items-center justify-between gap-3">
                    <p class="font-medium text-stone-900">{{ $check['label'] }}</p>
                    <span
                        class="{{ $check['ready'] ? 'bg-emerald-200 text-emerald-800' : 'bg-amber-200 text-amber-800' }} rounded-full px-3 py-1 text-xs font-semibold tracking-[0.2em] uppercase"
                    >
                        {{ $check['ready'] ? __('frontend.checklist.ok') : __('frontend.checklist.review') }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-stone-600">{{ $check['value'] }}</p>
            </div>
        @endforeach
    </div>
</section>
