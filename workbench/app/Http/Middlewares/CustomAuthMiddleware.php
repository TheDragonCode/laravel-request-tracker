<?php

declare(strict_types=1);

namespace Workbench\App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workbench\App\Models\User;

use function abort_if;
use function config;

final readonly class CustomAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isGuest()) {
            $this->loginOrThrow($request->bearerToken());
        }

        return $next($request);
    }

    protected function loginOrThrow(?string $token): void
    {
        $this->throwIf(
            $user = $this->user($token)
        );

        $this->login($user);
    }

    protected function login(User $user): void
    {
        Auth::login($user);
    }

    protected function isGuest(): bool
    {
        return Auth::guest();
    }

    protected function user(?string $token): ?User
    {
        if ($token !== config('services.custom_auth.token')) {
            return null;
        }

        return User::findOrFail(12);
    }

    protected function throwIf(?User $user): void
    {
        abort_if(! $user, 401, 'Unauthorized');
    }
}
