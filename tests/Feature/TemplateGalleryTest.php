<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('loads the template options page', function (): void {
    get(route('templates.index'))
        ->assertOk()
        ->assertSee(__('frontend.templates.page_headline'))
        ->assertSee(__('frontend.templates.shadcn_name'));
});

it('loads the shadcn template preview', function (): void {
    get(route('templates.show', 'shadcn'))
        ->assertOk()
        ->assertSee(__('frontend.templates.shadcn_headline'));
});

it('uses the persisted user template across the template pages', function (): void {
    $user = User::factory()->create([
        'frontend_template' => 'shadcn',
    ]);

    actingAs($user);

    get(route('templates.index'))
        ->assertOk()
        ->assertSee(__('frontend.templates.current'));
});
