<?php

declare(strict_types=1);

use Workbench\App\Models\Page;
use Workbench\App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('success', function () {
    $user = User::factory()->state([
        'id' => 2,
    ])->create();

    $page = Page::factory()->state([
        'id'      => 3,
        'user_id' => $user->id,
    ])->create();

    actingAs($user);

    $response = getJson(route('authorization.policy.show', ['page' => $page->id]))
        ->assertSuccessful()
        ->assertJsonPath('userId', $page->user_id)
        ->assertJsonPath('pageId', $page->id)
        ->assertJsonPath('accept', true);

    expect($response->json())->toMatchSnapshot();
});

test('deny', function () {
    $page = Page::factory()->create();

    actingAs($page->user);

    expect($page->id)->not->toBe(999);

    getJson(route('authorization.policy.show', ['page' => 999]))
        ->assertNotFound();
});

test('unauthorized', function () {
    getJson(route('authorization.policy.show', ['page' => 999]))
        ->assertUnauthorized();
});
