<?php

declare(strict_types=1);

use Workbench\App\Http\Controllers\MainController;

app('router')->get('headers', MainController::class)->name('headers');
