<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Http\Middleware\PrependTrackerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

it('sets headers and context for guest user', function () {
    $middleware = app(PrependTrackerMiddleware::class);

    $captured = null;

    $response = $middleware->handle(
        makeRequest(ip: '198.51.100.42'),
        function (Request $request) use (&$captured): Response {
            $captured = $request;

            return new Response('OK', 200);
        }
    );

    expect($response->getStatusCode())->toBe(200);

    $ip    = $captured->headers->get('X-Tracker-Ip');
    $trace = $captured->headers->get('X-Tracker-Trace-Id');

    expect($ip)->toBe('198.51.100.42');
    expect($trace)->not()->toBeEmpty()->and(Str::isUuid($trace))->toBeTrue();

    $context = context('tracker');

    expect($context)
        ->toBeArray()
        ->toHaveKeys(['ip', 'traceId', 'parentTraceId'])
        ->not
        ->toHaveKey('userId');

    expect($context['ip'])->toBe('198.51.100.42');
    expect($context['traceId'])->toBeUuid()->toBe($trace);
    expect($context['parentTraceId'])->toBeUuid();
});

it('respects existing tracker headers', function () {
    $middleware = app(PrependTrackerMiddleware::class);

    $existing = [
        'X-Tracker-User-Id'  => '777',
        'X-Tracker-Ip'       => '192.0.2.55',
        'X-Tracker-Trace-Id' => (string) Str::uuid(),
    ];

    $captured = null;

    $middleware->handle(
        makeRequest(headers: $existing),
        function (Request $request) use (&$captured): Response {
            $captured = $request;

            return new Response('OK', 200);
        }
    );

    foreach ($existing as $key => $value) {
        expect($captured->headers->get($key))->toBe($value);
    }

    $context = context('tracker');

    expect($context)->not->toHaveKey('userId');
    expect($context['ip'])->toBe('192.0.2.55');
    expect($context['traceId'])->toBe($existing['X-Tracker-Trace-Id']);
    expect($context['parentTraceId'])->toBeUuid();
});
