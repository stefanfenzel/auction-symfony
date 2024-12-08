<?php

namespace App\Domain\Users;

use App\Domain\Auctions\Auction;
use App\Infrastructure\Users\Repository\DoctrineUserRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DoctrineUserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var Collection<int, Auction>
     */
    #[ORM\OneToMany(targetEntity: Auction::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $auctions;

    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(name: 'id', type: Types::BIGINT, length: 20)]
        private int $id,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        private string $name,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Email]
        private string $email,

        #[ORM\Column(name: 'email_verified_at', type: Types::TIME_MUTABLE, nullable: true)]
        private ?DateTimeInterface $emailVerifiedAt = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        private string $password,

        #[ORM\Column(name: 'remember_token', length: 100, nullable: true)]
        private ?string $rememberToken = null,

        #[ORM\Column(name: 'created_at')]
        private DateTimeImmutable $createdAt,

        #[ORM\Column(name: 'updated_at')]
        private DateTimeImmutable $updatedAt,
    ) {
        $this->auctions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken(): string
    {
        return $this->rememberToken;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Auction>
     */
    public function getAuctions(): Collection
    {
        return $this->auctions;
    }

    public function addAuction(Auction $auction): static
    {
        if (!$this->auctions->contains($auction)) {
            $this->auctions->add($auction);
        }

        return $this;
    }

    public function removeAuction(Auction $auction): static
    {
        $this->auctions->removeElement($auction);

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
