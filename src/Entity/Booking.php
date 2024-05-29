<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual([
        'value' => 1,
    ])]
    #[Assert\LessThanOrEqual([
        'value' => 4,
    ])]
    #[ORM\Column(type: 'integer')]
    private ?int $booking_status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    private ?Expedition $expedition = null;

    public function __construct()
    {
        $this->booking_status = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingStatus(): ?int
    {
        return $this->booking_status;
    }

    public function setBookingStatus(int $booking_status): static
    {
        $this->booking_status = $booking_status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->created_at = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updated_at = new \DateTimeImmutable();

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

    public function getExpedition(): ?Expedition
    {
        return $this->expedition;
    }

    public function setExpedition(?Expedition $expedition): static
    {
        $this->expedition = $expedition;

        return $this;
    }
}
