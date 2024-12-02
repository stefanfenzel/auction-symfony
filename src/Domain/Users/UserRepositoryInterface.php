<?php

declare(strict_types=1);

namespace App\Domain\Users;

interface UserRepositoryInterface
{
    public function save(User $user): void;
}
