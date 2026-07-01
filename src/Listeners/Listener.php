<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Listeners;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;
use DragonCode\RequestTracker\TrackerRequest;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class Listener
{
    public function __construct(
        protected TrackerRequest $tracker,
        protected ContextHelper $helper,
    ) {}

    protected function setUser(?Authenticatable $user): void
    {
        $this->fillOrForget($user);

        $this->helper->store($this->data());
    }

    protected function fillOrForget(?Authenticatable $user): void
    {
        $user ? $this->fill($user) : $this->forget();
    }

    protected function fill(Authenticatable $user): void
    {
        $this->tracker->userId(
            $user->getAuthIdentifier()
        );
    }

    protected function forget(): void
    {
        $this->tracker->userId();
        $this->helper->forget(ContextKeyEnum::UserId);
    }

    protected function data(): ContextData
    {
        return new ContextData(
            userId : $this->tracker->getUserId(),
            ip     : $this->tracker->getIp(),
            traceId: $this->tracker->getTraceId(),
        );
    }
}
