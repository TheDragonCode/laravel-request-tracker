<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Transformers;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use Illuminate\Contracts\Support\Arrayable;

abstract class Transformer implements Arrayable
{
    public function __construct(
        protected ContextData $context
    ) {}

    protected function setResult(&$result, string $key, ?string $value): void
    {
        if (! $value) {
            return;
        }

        $result[$key] = $value;
    }
}
