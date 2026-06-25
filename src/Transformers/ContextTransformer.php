<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Transformers;

use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use Illuminate\Support\Facades\Context;

class ContextTransformer extends Transformer
{
    public function toArray(): array
    {
        $result = [];

        $this->setResult($result, ContextKeyEnum::UserId->value, $this->context->userId);
        $this->setResult($result, ContextKeyEnum::Ip->value, $this->context->ip);
        $this->setResult($result, ContextKeyEnum::TraceId->value, $this->context->traceId);

        if ($trace = $this->getParentTraceId()) {
            $result[ContextKeyEnum::ParentTraceId->value] = $trace;
        }

        return $result;
    }

    protected function getParentTraceId(): ?string
    {
        $context = Context::get(TrackerConfig::contextKey(), []);

        if ($parent = $context['parentTraceId'] ?? null) {
            return $parent;
        }

        $trace = $context['traceId'] ?? null;

        return $trace === $this->context->traceId ? null : $trace;
    }
}
