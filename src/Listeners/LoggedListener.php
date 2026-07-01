<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker\Listeners;

use Illuminate\Auth\Events\Authenticated;

class LoggedListener extends Listener
{
    public function handle(Authenticated $event): void
    {
        $this->setUser($event->user);
    }
}
