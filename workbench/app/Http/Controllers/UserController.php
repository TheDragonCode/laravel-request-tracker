<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\Request;

use function response;

class UserController
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'id' => $request->user()->id,
        ]);
    }
}
