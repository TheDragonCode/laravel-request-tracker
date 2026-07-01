<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Workbench\App\Models\Page;
use Workbench\App\Policies\PagePolicy;

class PolicyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Page::class, PagePolicy::class);
    }
}
