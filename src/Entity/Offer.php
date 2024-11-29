<?php

namespace App\Entity;

use App\Domain\Uuid;
use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, length: 36)]
    private ?Uuid $id = null;

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

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
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
