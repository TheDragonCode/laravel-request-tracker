<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
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

            'context' => Context::all(),
        ]);
    }
}
