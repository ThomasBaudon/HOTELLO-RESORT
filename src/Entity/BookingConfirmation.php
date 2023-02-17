<?php

namespace App\Entity;

use App\Repository\BookingConfirmationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingConfirmationRepository::class)]
class BookingConfirmation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?bool $booking_status = null;

    #[ORM\Column]
    private ?int $adults_cap = null;

    #[ORM\Column]
    private ?int $children_cap = null;

    #[ORM\Column]
    private ?int $total_cost = null;

    #[ORM\ManyToOne(inversedBy: 'bookingConfirmations')]
    private ?Room $room = null;

    #[ORM\ManyToOne(inversedBy: 'bookingConfirmations')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isBookingStatus(): ?bool
    {
        return $this->booking_status;
    }

    public function setBookingStatus(bool $booking_status): self
    {
        $this->booking_status = $booking_status;

        return $this;
    }

    public function getAdultsCap(): ?int
    {
        return $this->adults_cap;
    }

    public function setAdultsCap(int $adults_cap): self
    {
        $this->adults_cap = $adults_cap;

        return $this;
    }

    public function getChildrenCap(): ?int
    {
        return $this->children_cap;
    }

    public function setChildrenCap(int $children_cap): self
    {
        $this->children_cap = $children_cap;

        return $this;
    }

    public function getTotalCost(): ?int
    {
        return $this->total_cost;
    }

    public function setTotalCost(int $total_cost): self
    {
        $this->total_cost = $total_cost;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
