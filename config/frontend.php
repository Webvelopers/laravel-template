<?php

declare(strict_types=1);

return [
    'assets' => [
        'use_build_in_local' => (bool) env('FRONTEND_USE_BUILD_IN_LOCAL', false),
    ],
    'locales' => [
        'default' => env('APP_LOCALE', 'en'),
        'supported' => ['en', 'es'],
    ],
    'templates' => [
        'default' => 'default',
        'supported' => ['default', 'shadcn'],
    ],
];
