<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

final class StarterChecklist extends Component
{
    /**
     * @return array<int, array{label: string, value: string, ready: bool}>
     */
    public function checks(): array
    {
        return [
            [
                'label' => 'PHP runtime',
                'value' => sprintf('PHP %s', PHP_VERSION),
                'ready' => version_compare(PHP_VERSION, '8.2.0', '>='),
            ],
            [
                'label' => 'Application locale',
                'value' => sprintf('%s (%s)', $this->stringValue(config('app.locale')), $this->stringValue(config('app.timezone'))),
                'ready' => filled(config('app.locale')) && filled(config('app.timezone')),
            ],
            [
                'label' => 'Queue driver',
                'value' => $this->stringValue(config('queue.default')),
                'ready' => config('queue.default') === 'database',
            ],
            [
                'label' => 'Session driver',
                'value' => $this->stringValue(config('session.driver')),
                'ready' => config('session.driver') === 'database',
            ],
            [
                'label' => 'Cache store',
                'value' => $this->stringValue(config('cache.default')),
                'ready' => in_array(config('cache.default'), ['database', 'redis'], true),
            ],
            [
                'label' => 'Mail driver',
                'value' => $this->stringValue(config('mail.default')),
                'ready' => filled(config('mail.default')),
            ],
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.starter-checklist', [
            'checks' => $this->checks(),
        ]);
    }

    private function stringValue(mixed $value): string
    {
        if (is_scalar($value) || $value === null) {
            return (string) $value;
        }

        return 'n/a';
    }
}
