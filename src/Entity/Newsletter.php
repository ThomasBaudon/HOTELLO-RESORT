<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\NewsletterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter
{

    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $subscription_status = null;

    #[ORM\OneToOne(inversedBy: 'newsletter', cascade: ['persist', 'remove'])]
    private ?User $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function isSubscriptionStatus(): ?bool
    {
        return $this->subscription_status;
    }

    public function setSubscriptionStatus(bool $subscription_status): self
    {
        $this->subscription_status = $subscription_status;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }
}
