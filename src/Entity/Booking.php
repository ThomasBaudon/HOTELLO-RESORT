<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?bool $booking_status = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Room $room_id = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $adults_cap = null;

    #[ORM\Column]
    private ?int $children_cap = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

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

    public function isBookingStatus(): ?bool
    {
        return $this->booking_status;
    }

    public function setBookingStatus(bool $booking_status): self
    {
        $this->booking_status = $booking_status;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room_id;
    }

    public function setRoom(?Room $room_id): self
    {
        $this->room_id = $room_id;

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
}
