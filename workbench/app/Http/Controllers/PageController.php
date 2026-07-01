<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Workbench\App\Models\Page;

class PageController
{
    public function __invoke(Request $request, Page $page): JsonResponse
    {
        $userId = $request->user()->id;

        return response()->json([
            'userId' => $userId,
            'pageId' => $page->id,

            'accept' => $userId === $page->user_id,

            'headers' => [
                TrackerConfig::headerUserId()  => $request->headers->get(TrackerConfig::headerUserId()),
                TrackerConfig::headerIp()      => $request->headers->get(TrackerConfig::headerIp()),
                TrackerConfig::headerTraceId() => $request->headers->get(TrackerConfig::headerTraceId()),
            ],
        ]);
    }
}
