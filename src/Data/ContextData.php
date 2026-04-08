<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Data;

use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Context;

class ContextData implements Arrayable
{
    public function __construct(
        protected ?string $userId = null,
        protected ?string $ip = null,
        protected ?string $traceId = null,
    ) {}

    public function toArray(): array
    {
        $result = [];

        $this->setResult($result, ContextKeyEnum::UserId, $this->userId);
        $this->setResult($result, ContextKeyEnum::Ip, $this->ip);
        $this->setResult($result, ContextKeyEnum::TraceId, $this->traceId);

        if ($trace = $this->getParentTraceId()) {
            $result[ContextKeyEnum::ParentTraceId->value] = $trace;
        }

        return $result;
    }

    protected function setResult(&$result, ContextKeyEnum $key, ?string $value): void
    {
        if ($value) {
            $result[$key->value] = $value;
        }
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
