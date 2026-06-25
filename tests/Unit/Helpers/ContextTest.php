<?php

declare(strict_types=1);

use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;

test('filled', function () {
    setContext();

    $context = new ContextHelper;

    expect([
        'all' => $context->all(),

        'getUserId' => $context->getUserId(),
        'getIp'     => $context->getIp(),

        'getTraceId'       => $context->getTraceId(),
        'getParentTraceId' => $context->getParentTraceId(),
    ])->toMatchSnapshot();
});
