<?php

declare(strict_types=1);

it('loads the auth pages', function (): void {
    $this->get(route('login'))->assertOk();
    $this->get(route('register'))->assertOk();
    $this->get(route('password.request'))->assertOk();
});

it('redirects guests away from protected pages', function (): void {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
    $this->get(route('profile'))->assertRedirect(route('login'));
});
