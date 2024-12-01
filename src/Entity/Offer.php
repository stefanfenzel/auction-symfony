<?php

namespace App\Entity;

use App\Infrastructure\Offers\Repository\DoctrineOfferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineOfferRepository::class)]
#[ORM\Table(name: 'offers')]
class Offer
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Auction $auction = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?float $bidAmount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $bidTime = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): static
    {
        $this->auction = $auction;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBidAmount(): ?float
    {
        return $this->bidAmount;
    }

    public function setBidAmount(float $bidAmount): static
    {
        $this->bidAmount = $bidAmount;

        return $this;
    }

    public function getBidTime(): ?\DateTimeImmutable
    {
        return $this->bidTime;
    }

    public function setBidTime(\DateTimeImmutable $bidTime): static
    {
        $this->bidTime = $bidTime;

        return $this;
    }
}
