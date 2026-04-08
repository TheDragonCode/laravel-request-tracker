<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Enums;

enum ContextKeyEnum: string
{
    case UserId        = 'userId';
    case Ip            = 'ip';
    case TraceId       = 'traceId';
    case ParentTraceId = 'parentTraceId';
}
