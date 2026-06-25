<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Http\Middleware;

use Closure;
use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;
use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Middleware
{
    public function __construct(
        protected ContextHelper $helper,
    ) {}

    protected function tracker(Request $request): TrackerRequest
    {
        return new TrackerRequest($request, $this->headers());
    }

    protected function headers(): TrackerHeader
    {
        return new TrackerHeader(
            userId : TrackerConfig::headerUserId(),
            ip     : TrackerConfig::headerIp(),
            traceId: TrackerConfig::headerTraceId(),
        );
    }

    protected function modify(TrackerRequest $tracker, Closure $next): Response
    {
        return $next(
            $tracker->getRequest()
        );
    }
}
