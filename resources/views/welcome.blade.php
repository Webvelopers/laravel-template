<x-layouts.app :title="config('app.name') . ' | ' . __('frontend.welcome.title')">
    <section class="space-y-10">
        @include($frontendTemplate === 'shadcn' ? 'templates.shadcn' : 'templates.default')

        <x-templates.options :active-template="$frontendTemplate" />
    </section>
</x-layouts.app>
