<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;

test('headers', function () {
    $response = getJson(route('headers'))->assertSuccessful();

    expect($response->json())
        ->not->toBeEmpty()
        ->toMatchSnapshot();
});
