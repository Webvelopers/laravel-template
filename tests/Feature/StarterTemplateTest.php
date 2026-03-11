<?php

declare(strict_types=1);

it('redirects the legacy home path to the dashboard path', function (): void {
    $this->get('/home')->assertRedirect('/dashboard');
});

it('renders the landing page in english when the session locale is english', function (): void {
    $this->withSession(['locale' => 'en'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee('Laravel 12 starter kit')
        ->assertSee('Read documentation');
});

it('rejects unsupported locales', function (): void {
    $this->from(route('home'))
        ->post(route('locale.update'), ['locale' => 'fr'])
        ->assertRedirect(route('home'))
        ->assertSessionHasErrors('locale');
});
