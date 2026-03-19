<?php

declare(strict_types=1);

return [
    'locales' => [
        'default' => env('APP_LOCALE', 'en'),
        'supported' => ['en', 'es'],
    ],
    'templates' => [
        'default' => 'default',
        'supported' => ['default', 'shadcn'],
    ],
];
