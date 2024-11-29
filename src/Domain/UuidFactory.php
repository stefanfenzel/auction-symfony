<?php

declare(strict_types=1);

namespace App\Domain;

interface UuidFactory
{
    public function create(): Uuid;
}
