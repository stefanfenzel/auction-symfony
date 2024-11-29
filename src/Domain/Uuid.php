<?php

declare(strict_types=1);

namespace App\Domain;

use Stringable;
use Webmozart\Assert\Assert;

final readonly class Uuid implements Stringable
{
    private function __construct(private string $uuid)
    {
        Assert::uuid($this->uuid);
    }

    public static function fromString(string $uuid): self
    {
        return new self(trim($uuid));
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->uuid;
    }
}
