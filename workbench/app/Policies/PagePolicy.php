<?php

declare(strict_types=1);

namespace Workbench\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Workbench\App\Models\Page;
use Workbench\App\Models\User;

class PagePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Page $page): Response
    {
        return $user->id === $page->user_id
            ? $this->allow()
            : $this->deny();
    }
}
