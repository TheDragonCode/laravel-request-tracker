<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Http\Middleware;

use DragonCode\RequestTracker\TrackerRequest;
use Illuminate\Support\Facades\Auth;

class UserMiddleware extends Middleware
{
    protected function trace(TrackerRequest $tracker): void
    {
        $tracker->userId($this->userId());
    }

    protected function userId(): ?string
    {
        if (! Auth::hasUser()) {
            return null;
        }

        return (string) Auth::id();
    }
}
