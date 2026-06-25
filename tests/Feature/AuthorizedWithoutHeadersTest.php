<?php

declare(strict_types=1);

use Workbench\App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('headers', function () {
    actingAs(new User);

    $response = getJson(route('headers'))->assertSuccessful();

    expect($response->json())
        ->not->toBeEmpty()
        ->toMatchSnapshot();
});
