<?php

declare(strict_types=1);

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

pest()
    ->printer()
    ->compact();

pest()
    ->extend(TestCase::class, WithWorkbench::class)
    ->in('Feature', 'Unit');
