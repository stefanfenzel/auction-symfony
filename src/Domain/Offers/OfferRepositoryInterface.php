<?php

declare(strict_types=1);

namespace App\Domain\Offers;

interface OfferRepositoryInterface
{
    public function save(Offer $offer): void;
}
