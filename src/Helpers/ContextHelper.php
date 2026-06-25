<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Helpers;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use Illuminate\Support\Facades\Context;

use function array_merge;

class ContextHelper
{
    public function store(ContextData $context): void
    {
        $data = array_merge($this->all(), $context->toArray());

        Context::add($this->key(), $data);
    }

    public function get(ContextKeyEnum $key): ?string
    {
        $data = $this->all();

        $value = $data[$key->value] ?? null;

        return $value ? (string) $value : null;
    }

    public function all(): array
    {
        return Context::get($this->key(), []);
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
