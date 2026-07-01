<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use DragonCode\RequestTracker\TrackerHeader;
use Workbench\App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('headers', function () {
    actingAs(new User(['id' => 123]));

    $headers = new TrackerHeader(
        userId : TrackerConfig::headerUserId(),
        ip     : TrackerConfig::headerIp(),
        traceId: TrackerConfig::headerTraceId(),
    );

    $response = getJson(route('headers'), [
        $headers->userId  => '777',
        $headers->ip      => '192.0.2.55',
        $headers->traceId => '019efec3-ab26-7338-8aa4-809a4709c390',
    ])->assertSuccessful();

    expect($response->json())
        ->not->toBeEmpty()
        ->toMatchSnapshot();
});
