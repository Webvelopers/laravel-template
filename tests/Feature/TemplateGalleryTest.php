<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserFrontendPreference;

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

it('returns not found for unsupported template previews', function (): void {
    get(route('templates.show', 'invalid-template'))
        ->assertNotFound();
});

it('uses the persisted user template across the template pages', function (): void {
    /** @var User $user */
    $user = User::factory()->create();

    UserFrontendPreference::updateTemplateFor($user, 'shadcn');

    actingAs($user);

    get(route('templates.index'))
        ->assertOk()
        ->assertSee(__('frontend.templates.current'));
});
