<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Helpers;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use Illuminate\Support\Facades\Context;

class ContextHelper
{
    public function store(ContextData $context): void
    {
        Context::add($this->key(), $context->toArray());
    }

    public function get(ContextKeyEnum $key): ?string
    {
        $data = Context::get($this->key(), []);

        return $data[$key->value] ?? null;
    }

    public function getUserId(): ?string
    {
        return $this->get(ContextKeyEnum::UserId);
    }

    public function getIp(): ?string
    {
        return $this->get(ContextKeyEnum::Ip);
    }

    public function getTraceId(): ?string
    {
        return $this->get(ContextKeyEnum::TraceId);
    }

    public function getParentTraceId(): ?string
    {
        return $this->get(ContextKeyEnum::ParentTraceId);
    }

    protected function key(): string
    {
        return TrackerConfig::contextKey();
    }
}
