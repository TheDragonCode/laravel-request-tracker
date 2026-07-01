<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Listeners;

class LogoutListener extends Listener
{
    public function handle(): void
    {
        $this->setUser(null);
    }
}
