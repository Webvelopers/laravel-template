<?php

declare(strict_types=1);

it('returns the welcome page data', function (): void {
    $data = [
        'title' => 'Laravel',
        'h1' => 'Let\'s get started',
    ];

    expect($data)
        ->toBeArray()
        ->toHaveKeys(['title', 'h1'])
        ->and($data['title'])->toBe('Laravel')
        ->and($data['h1'])->toBe('Let\'s get started');
});
