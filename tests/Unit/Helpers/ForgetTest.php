<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Enums\ContextKeyEnum;
use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;

test('forget', function (ContextKeyEnum $key): void {
    setContext();

    $context = new ContextHelper;

    $before = $context->all();

    $context->forget($key);

    $after = $context->all();

    expect([
        'before' => $before,
        'after'  => $after,
    ])->toMatchSnapshot();
})->with(ContextKeyEnum::cases());
