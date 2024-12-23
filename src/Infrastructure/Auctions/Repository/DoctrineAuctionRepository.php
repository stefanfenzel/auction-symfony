<?php

namespace App\Infrastructure\Auctions\Repository;

use App\Domain\Auctions\Auction;
use App\Domain\Auctions\AuctionRepositoryInterface;
use App\Domain\Uuid;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineAuctionRepository extends ServiceEntityRepository implements AuctionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auction::class);
    }

    public function findById(Uuid $id): ?Auction
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id->toString())
            ->orderBy('a.createdAt', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByUserId(int $userId): ArrayCollection
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('a.createdAt', 'ASC')
            ->getQuery();

        return new ArrayCollection($query->getResult());
    }

    public function findRunningAuctions(): ArrayCollection
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('a.endDate > :now')
            ->setParameter('now', new DateTime())
            ->orderBy('a.createdAt', 'ASC')
            ->getQuery();

        return new ArrayCollection($query->getResult());
    }

    public function save(Auction $auction): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($auction);
        $entityManager->flush();
    }

    public function delete(Uuid $id): void
    {
        $entityManager = $this->getEntityManager();
        $auction = $this->findById($id);

        if ($auction === null) {
            return;
        }

        $entityManager->remove($auction);
        $entityManager->flush();
    }
}
