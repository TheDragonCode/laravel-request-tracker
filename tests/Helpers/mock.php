<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerUuid;

function mockUuid(): void
{
    $uuid = Mockery::mock(TrackerUuid::class);
    $uuid->shouldReceive('generate')->andReturn(fakeUuid());

    app()->singleton(TrackerUuid::class, fn () => $uuid);
}
