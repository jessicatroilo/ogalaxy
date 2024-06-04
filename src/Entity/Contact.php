<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom doit contenir au plus {{ limit }} caractères',
    )]
    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Votre prénom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre prénom doit contenir au plus {{ limit }} caractères',
    )]
    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[Assert\NotBlank]
    #[Assert\Email([
        'message' => 'Votre adresse mail "{{ value }}" n\'est pas valide.',
    ])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\Choice(['Question générale', 'Demande d\'informations', 'Problème technique', 'Autre'])]
    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 1500,
        minMessage: 'Votre message doit contenir minimum {{ limit }} caractères',
        maxMessage: 'Votre message doit contenir maximum {{ limit }} caractères',
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[Assert\Date]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

}
