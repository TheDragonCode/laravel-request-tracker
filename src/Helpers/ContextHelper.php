<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Context;

class ContextHelper implements Arrayable
{
    protected ?string $userId = null;

    protected ?string $ip = null;

    protected ?string $traceId = null;

    public function userId(?string $id): static
    {
        $this->userId = $id;

        return $this;
    }

    public function ip(?string $ip): static
    {
        $this->ip = $ip;

        return $this;
    }

    public function traceId(?string $id): static
    {
        $this->traceId = $id;

        return $this;
    }

    public function toArray(): array
    {
        $result = [];

        if ($this->userId) {
            $result['userId'] = $this->userId;
        }

        if ($this->ip) {
            $result['ip'] = $this->ip;
        }

        if ($this->traceId) {
            $result['traceId'] = $this->traceId;
        }

        if ($trace = $this->getParentTraceId()) {
            $result['parentTraceId'] = $trace;
        }

        return $result;
    }

    public function store(): void
    {
        Context::add(TrackerConfig::contextKey(), $this->toArray());
    }

    protected function getParentTraceId(): ?string
    {
        $context = Context::get(TrackerConfig::contextKey(), []);

        if ($parent = $context['parentTraceId'] ?? null) {
            return $parent;
        }

        $trace = $context['traceId'] ?? null;

        return $trace === $this->traceId ? null : $trace;
    }
}
