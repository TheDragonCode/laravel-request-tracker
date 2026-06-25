<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Helpers;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Transformers\ContextTransformer;
use Illuminate\Support\Facades\Context;

use function array_filter;
use function array_merge;

class ContextHelper
{
    public function store(ContextData $context): void
    {
        $transformed = new ContextTransformer($context);

        $data = array_merge($this->all(), $transformed->toArray());

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

    public function headers(): array
    {
        return array_filter([
            TrackerConfig::headerUserId()  => $this->getUserId(),
            TrackerConfig::headerIp()      => $this->getIp(),
            TrackerConfig::headerTraceId() => $this->getTraceId(),
        ]);
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
