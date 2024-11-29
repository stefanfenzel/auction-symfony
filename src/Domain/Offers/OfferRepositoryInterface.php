<?php

declare(strict_types=1);

namespace App\Domain\Offers;

use App\Entity\Offer;

interface OfferRepositoryInterface
{
    public function save(Offer $offer): void;
}
