<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExpeditionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpeditionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Expedition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre titre doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre titre doit contenir au plus {{ limit }} caractères',
    )]
    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre titre de destination doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre titre de destination doit contenir au plus {{ limit }} caractères',
    )]
    #[ORM\Column(length: 50)]
    private ?string $destination = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departure = null;

    #[Assert\Positive]
    #[Assert\Range(
        min: 6,
        max: 30,
        notInRangeMessage: 'Vous devez choisir entre {{ min }} ou {{ max }} jours pour pouvoir créer l\'expédition',
    )]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $duration = null;

    #[Assert\Positive]
    #[Assert\Range(
        min: 4,
        max: 8,
        notInRangeMessage: 'Vous devez choisir entre {{ min }} ou {{ max }} passagers pour pouvoir créer l\'expédition',
    )]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $passenger = null;


    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 2000,
        minMessage: 'Votre description doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre description doit contenir au plus {{ limit }} caractères',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[Assert\Positive]
    #[Assert\GreaterThanOrEqual([
        'value' => 20000,
    ])]
    #[ORM\Column]
    private ?int $price = null;

    // #[Assert\Date]
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    // #[Assert\Date]
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'expedition')]
    private Collection $booking;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'expedition')]
    private Collection $users;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'expedition')]
    private Collection $review;



    public function __construct()
    {
        $this->booking = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;16;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): static
    {
        $this->departure = $departure;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPassenger(): ?int
    {
        return $this->passenger;
    }

    public function setPassenger(int $passenger): static
    {
        $this->passenger = $passenger;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->booking->contains($booking)) {
            $this->booking->add($booking);
            $booking->setExpedition($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->booking->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getExpedition() === $this) {
                $booking->setExpedition(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title ?? ''; // Retourne le titre de l'expédition s'il existe
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addExpedition($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeExpedition($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): static
    {
        if (!$this->review->contains($review)) {
            $this->review->add($review);
            $review->setExpedition($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getExpedition() === $this) {
                $review->setExpedition(null);
            }
        }

        return $this;
    }




}
