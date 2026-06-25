<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

use function response;

class MainController
{
    public function __invoke(Request $request): JsonResponse
    {
        $context = Context::get(TrackerConfig::contextKey(), []);

        unset($context['parentTraceId']);

        return response()->json([
            'headers' => [
                'userId'  => $request->header(TrackerConfig::headerUserId()),
                'ip'      => $request->header(TrackerConfig::headerIp()),
                'traceId' => $request->header(TrackerConfig::headerTraceId()),
            ],

            'context' => $context,
        ]);
    }
}
