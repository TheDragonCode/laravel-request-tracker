<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Http\Middleware;

use Closure;
use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\RequestTracker\TrackerRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrependTrackerMiddleware extends Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tracker = $this->tracker($request);

        $this->trace($tracker);
        $this->context($tracker);

        return $this->modify($tracker, $next);
    }

    protected function trace(TrackerRequest $tracker): void
    {
        $tracker->ip();
        $tracker->traceId();
    }

    protected function context(TrackerRequest $request): void
    {
        $data = new ContextData(
            ip     : $request->getIp(),
            traceId: $request->getTraceId(),
        );

        $this->helper->store($data);
    }
}
