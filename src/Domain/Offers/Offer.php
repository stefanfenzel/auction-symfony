<?php

namespace App\Domain\Offers;

use App\Domain\Auctions\Auction;
use App\Domain\Users\User;
use App\Infrastructure\Offers\Repository\DoctrineOfferRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineOfferRepository::class)]
#[ORM\Table(name: 'offers')]
class Offer
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string', length: 36)]
        private string $id,
        #[ORM\ManyToOne(inversedBy: 'offers')]
        #[ORM\JoinColumn(nullable: false)]
        private Auction $auction,
        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
        private User $user,
        #[ORM\Column]
        private float $bidAmount,
        #[ORM\Column]
        private DateTimeImmutable $bidTime,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuction(): Auction
    {
        return $this->auction;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getBidAmount(): float
    {
        return $this->bidAmount;
    }

    public function getBidTime(): DateTimeImmutable
    {
        return $this->bidTime;
    }
}
