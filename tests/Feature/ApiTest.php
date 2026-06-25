<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;

use function Pest\Laravel\getJson;

test('without tracker', function () {
    $response1 = getJson(route('headers'))->assertSuccessful();
    $response2 = getJson(route('headers'))->assertSuccessful();

    $keyUserId  = sprintf('%s.0', strtolower(TrackerConfig::headerUserId()));
    $keyIp      = sprintf('%s.0', strtolower(TrackerConfig::headerIp()));
    $keyTraceId = sprintf('%s.0', strtolower(TrackerConfig::headerTraceId()));

    $response1->assertJsonMissingPath($keyUserId);
    $response2->assertJsonMissingPath($keyUserId);

    $response1->assertJsonPath($keyIp, $response2->json($keyIp));

    $trace1 = $response1->json($keyTraceId);
    $trace2 = $response2->json($keyTraceId);

    expect($trace1)->not->toBe($trace2);

    expect($trace1)->toBeUuid();
    expect($trace2)->toBeUuid();
});

test('with tracker', function () {
    $userId  = '777';
    $ip      = '192.0.2.55';
    $traceId = '019efec3-ab26-7338-8aa4-809a4709c390';

    $headers = [
        TrackerConfig::headerUserId()  => $userId,
        TrackerConfig::headerIp()      => $ip,
        TrackerConfig::headerTraceId() => $traceId,
    ];

    $response1 = getJson(route('headers'), $headers)->assertSuccessful();
    $response2 = getJson(route('headers'), $headers)->assertSuccessful();

    $keyUserId  = sprintf('%s.0', strtolower(TrackerConfig::headerUserId()));
    $keyIp      = sprintf('%s.0', strtolower(TrackerConfig::headerIp()));
    $keyTraceId = sprintf('%s.0', strtolower(TrackerConfig::headerTraceId()));

    $response1->assertJsonPath($keyUserId, $userId);
    $response1->assertJsonPath($keyIp, $ip);
    $response1->assertJsonPath($keyTraceId, $traceId);

    $response2->assertJsonPath($keyUserId, $userId);
    $response2->assertJsonPath($keyIp, $ip);
    $response2->assertJsonPath($keyTraceId, $traceId);
});
