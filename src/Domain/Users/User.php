<?php

namespace App\Domain\Users;

use App\Domain\Auctions\Auction;
use App\Infrastructure\Users\Repository\DoctrineUserRepository;
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
        private ?int $id = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        private ?string $name = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Email]
        private ?string $email = null,

        #[ORM\Column(name: 'email_verified_at', type: Types::TIME_MUTABLE, nullable: true)]
        private ?\DateTimeInterface $emailVerifiedAt = null,

        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        private ?string $password = null,

        #[ORM\Column(name: 'remember_token', length: 100, nullable: true)]
        private ?string $rememberToken = null,

        #[ORM\Column(name: 'created_at')]
        private ?\DateTimeImmutable $createdAt = null,

        #[ORM\Column(name: 'updated_at')]
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->auctions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailVerifiedAt(): ?\DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(?\DateTimeInterface $emailVerifiedAt): static
    {
        $this->emailVerifiedAt = $emailVerifiedAt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken(?string $rememberToken): static
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
