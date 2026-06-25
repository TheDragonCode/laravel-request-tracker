<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Http\Middleware;

use Closure;
use DragonCode\LaravelRequestTracker\Data\ContextData;
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

    public function handle(Request $request, Closure $next): Response
    {
        $tracker = $this->tracker($request);

        $this->trace($tracker);
        $this->context($tracker);

        return $this->modify($tracker, $next);
    }

    protected function modify(TrackerRequest $tracker, Closure $next): Response
    {
        return $next(
            $tracker->getRequest()
        );
    }

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

    protected function context(TrackerRequest $request): void
    {
        $data = new ContextData(
            userId : $request->getUserId(),
            ip     : $request->getIp(),
            traceId: $request->getTraceId(),
        );

        $this->helper->store($data);
    }
}
