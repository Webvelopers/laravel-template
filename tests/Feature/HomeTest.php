<?php

declare(strict_types=1);

it('loads the homepage successfully', function (): void {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee(__('frontend.welcome.title'));
});
