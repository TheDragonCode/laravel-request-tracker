<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

pest()
    ->printer()
    ->compact();

pest()
    ->extend(TestCase::class, WithWorkbench::class, RefreshDatabase::class)
    ->in('Feature', 'Unit')
    ->beforeEach(function () {
        mockUuid();
    })
    ->afterEach(function () {
        expect('fallback')->toMatchSnapshot();
    });
