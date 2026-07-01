<?php

declare(strict_types=1);

use Workbench\App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('authorized', function () {
    $user = User::factory()->create();

    actingAs($user);

    getJson(route('authorization.default'))
        ->assertSuccessful()
        ->assertJsonPath('id', $user->id);
});

test('unauthorized', function () {
    getJson(route('authorization.default'))
        ->assertUnauthorized();
});
