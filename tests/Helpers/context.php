<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use Illuminate\Support\Facades\Context;

function setContext(): void
{
    $root = TrackerConfig::contextKey();

    $context = [
        ContextKeyEnum::UserId->value        => 123,
        ContextKeyEnum::Ip->value            => '192.0.2.55',
        ContextKeyEnum::TraceId->value       => fakeUuid(),
        ContextKeyEnum::ParentTraceId->value => fakeUuid(false),
    ];

    Context::add($root, $context);
}

function setParentTraceId(): void
{
    $root = TrackerConfig::contextKey();

    $context = Context::get($root, []);

    $context['parentTraceId'] = fakeUuid(false);

    Context::add($root, $context);
}
