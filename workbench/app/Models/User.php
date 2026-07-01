<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $attributes = [
        'id' => 123,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
