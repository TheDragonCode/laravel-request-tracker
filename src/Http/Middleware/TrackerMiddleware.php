<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Http\Middleware;

use DragonCode\RequestTracker\TrackerRequest;

class TrackerMiddleware extends Middleware
{
    protected function trace(TrackerRequest $tracker): void
    {
        $tracker->ip();
        $tracker->traceId();
    }
}
