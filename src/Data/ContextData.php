<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Data;

readonly class ContextData
{
    public function __construct(
        public ?string $userId = null,
        public ?string $ip = null,
        public ?string $traceId = null,
    ) {}
}
