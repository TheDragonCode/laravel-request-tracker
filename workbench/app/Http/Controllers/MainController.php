<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function response;

class MainController
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(
            $request->headers->all()
        );
    }
}
