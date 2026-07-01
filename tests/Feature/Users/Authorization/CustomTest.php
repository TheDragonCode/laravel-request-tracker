<?php

declare(strict_types=1);

use Workbench\App\Models\User;

use function Pest\Laravel\getJson;
use function Pest\Laravel\withToken;

test('authorized', function () {
    User::factory()->state([
        'id' => 12,
    ])->create();

    withToken(config('services.custom_auth.token'));

    getJson(route('authorization.custom'), [])
        ->assertSuccessful()
        ->assertJsonPath('id', 12);
});

test('unauthorized', function () {
    getJson(route('authorization.custom'))
        ->assertUnauthorized();
});
