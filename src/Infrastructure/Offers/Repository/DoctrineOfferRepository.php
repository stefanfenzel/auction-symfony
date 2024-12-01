<?php

namespace App\Infrastructure\Offers\Repository;

use App\Domain\Offers\Offer;
use App\Domain\Offers\OfferRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 */
class DoctrineOfferRepository extends ServiceEntityRepository implements OfferRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $offer): void
    {
        $this->_em->persist($offer);
        $this->_em->flush();
    }
}
