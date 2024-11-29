<?php

declare(strict_types=1);

namespace App\App;

use App\Domain\Uuid;
use App\Domain\UuidFactory;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

final class UuidFromSymfonyFactory implements UuidFactory
{
    public function create(): Uuid
    {
        return Uuid::fromString(SymfonyUuid::v7()->toString());
    }
}
