<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workbench\App\Models\User;

function makeRequest(string $ip = '203.0.113.10', ?User $user = null, array $headers = []): Request
{
    $request = Request::create(uri: '/', server: [
        'REMOTE_ADDR' => $ip,
    ]);

    foreach ($headers as $key => $value) {
        $request->headers->set($key, $value);
    }

    if ($user) {
        Auth::setUser($user);
    }

    return $request;
}
