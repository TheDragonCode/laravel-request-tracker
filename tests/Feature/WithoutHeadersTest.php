<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;

test('empty', function () {
    $response = getJson(route('headers'))
        ->assertSuccessful()
        ->assertJsonPath('headers.userId', null)
        ->assertJsonPath('headers.ip', '127.0.0.1')
        ->assertJsonPath('context.tracker.ip', '127.0.0.1');

    expect($response->json('headers.traceId'))->toBeUuid();
    expect($response->json('context.tracker.traceId'))->toBeUuid();
    expect($response->json('context.tracker.parentTraceId'))->toBeUuid();
});
