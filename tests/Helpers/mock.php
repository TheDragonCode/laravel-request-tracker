<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerUuid;

function mockUuid(): void
{
    $uuid = Mockery::mock(TrackerUuid::class);
    $uuid->shouldReceive('generate')->andReturn('019f0068-357b-741b-97bd-1299d104fb5a');

    app()->singleton(TrackerUuid::class, fn () => $uuid);
}
