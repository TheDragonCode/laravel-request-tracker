<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Helpers;

use function config;

class TrackerConfig
{
    public static function contextKey(): string
    {
        return config('request-tracker.context.key');
    }

    public static function headerUserId(): string
    {
        return config()->string('request-tracker.headers.user_id');
    }

    public static function headerIp(): string
    {
        return config()->string('request-tracker.headers.ip');
    }

    public static function headerTraceId(): string
    {
        return config()->string('request-tracker.headers.trace_id');
    }
}
