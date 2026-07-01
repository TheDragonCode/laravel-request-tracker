<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Page;
use Workbench\App\Models\User;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'title' => $this->faker->word(),
        ];
    }
}
