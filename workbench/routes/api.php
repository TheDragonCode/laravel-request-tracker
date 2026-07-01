<?php

declare(strict_types=1);

use Workbench\App\Http\Controllers\MainController;
use Workbench\App\Http\Controllers\PageController;
use Workbench\App\Http\Controllers\UserController;
use Workbench\App\Http\Middlewares\CustomAuthMiddleware;

app('router')->get('headers', MainController::class)->name('headers');

app('router')
    ->name('authorization.')
    ->prefix('authorization')
    ->group(static function () {
        app('router')
            ->middleware('auth')
            ->get('default', UserController::class)
            ->name('default');

        app('router')
            ->middleware(CustomAuthMiddleware::class)
            ->get('custom', UserController::class)
            ->name('custom');

        app('router')
            ->middleware('auth')
            ->get('policy/{page}', PageController::class)
            ->name('policy.show')
            ->can('view', 'page');
    });
