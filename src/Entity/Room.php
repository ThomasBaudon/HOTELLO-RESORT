<?php

namespace App\Entity;

use Stringable;
use App\Entity\Review;
use DateTimeImmutable;
use App\Entity\Equipment;
use App\Entity\PhotoRoom;
use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[Uploadable]
class Room implements Stringable
{
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $title_room = null;

    #[ORM\Column]
    #[GreaterThan(value: 0)]
    private ?int $price_room = null;

    #[ORM\Column(length: 25)]
    private ?string $type_room = null;

    #[ORM\Column]
    #[GreaterThan(value: 0)]
    private ?int $size_room = null;

    #[ORM\Column(type: Types::TEXT)]
    #[NotBlank(message: 'Veuillez renseigner une description.')]
    private ?string $description_room = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(1)]
    private ?int $adults_cap = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $children_cap = null;

    #[ORM\Column]
    private ?bool $status_room = null;


    #[ORM\OneToMany(mappedBy: 'id_room', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Equipment::class, mappedBy: 'room')]
    private Collection $equipment;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: PhotoRoom::class)]
    private Collection $photo_room;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[UploadableField(mapping: 'room_images', fileNameProperty: 'image')]
    private ?File $roomMainImage = null;

    #[ORM\Column(type:"datetime_immutable", options: ['default' =>'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $updated_at;

    #[ORM\OneToMany(mappedBy: 'room_id', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: BookingConfirmation::class)]
    private Collection $bookingConfirmations;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->photo_room = new ArrayCollection();
        $this->updated_at = new DateTimeImmutable();
        $this->bookings = new ArrayCollection();
        $this->bookingConfirmations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleRoom(): ?string
    {
        return $this->title_room;
    }

    public function setTitleRoom(string $title_room): self
    {
        $this->title_room = $title_room;

        return $this;
    }

    public function getPriceRoom(): ?int
    {
        return $this->price_room;
    }

    public function setPriceRoom(int $price_room): self
    {
        $this->price_room = $price_room;

        return $this;
    }

    public function getTypeRoom(): ?string
    {
        return $this->type_room;
    }

    public function setTypeRoom(string $type_room): self
    {
        $this->type_room = $type_room;

        return $this;
    }

    public function getSizeRoom(): ?int
    {
        return $this->size_room;
    }

    public function setSizeRoom(int $size_room): self
    {
        $this->size_room = $size_room;

        return $this;
    }

    public function getDescriptionRoom(): ?string
    {
        return $this->description_room;
    }

    public function setDescriptionRoom(string $description_room): self
    {
        $this->description_room = $description_room;

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

    public function isStatusRoom(): ?bool
    {
        return $this->status_room;
    }

    public function setStatusRoom(bool $status_room): self
    {
        $this->status_room = $status_room;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setIdRoom($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getIdRoom() === $this) {
                $review->setIdRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment->add($equipment);
            $equipment->addRoom($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            $equipment->removeRoom($this);
        }

        return $this;
    }

    /* TO STRING */
    public function __toString(): string
    {
        return $this->title_room;
    }

    /**
     * @return Collection<int, PhotoRoom>
     */
    public function getPhotoRoom(): Collection
    {
        return $this->photo_room;
    }

    public function addPhotoRoom(PhotoRoom $photoRoom): self
    {
        if (!$this->photo_room->contains($photoRoom)) {
            $this->photo_room->add($photoRoom);
            $photoRoom->setRoom($this);
        }

        return $this;
    }

    public function removePhotoRoom(PhotoRoom $photoRoom): self
    {
        if ($this->photo_room->removeElement($photoRoom)) {
            // set the owning side to null (unless already changed)
            if ($photoRoom->getRoom() === $this) {
                $photoRoom->setRoom(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRoomMainImage(): ?File
    {
        return $this->roomMainImage;
    }

    public function setRoomMainImage(?File $roomMainImage): self
    {
        $this->roomMainImage = $roomMainImage;
        $this->updated_at = new DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookingConfirmation>
     */
    public function getBookingConfirmations(): Collection
    {
        return $this->bookingConfirmations;
    }

    public function addBookingConfirmation(BookingConfirmation $bookingConfirmation): self
    {
        if (!$this->bookingConfirmations->contains($bookingConfirmation)) {
            $this->bookingConfirmations->add($bookingConfirmation);
            $bookingConfirmation->setRoom($this);
        }

        return $this;
    }

    public function removeBookingConfirmation(BookingConfirmation $bookingConfirmation): self
    {
        if ($this->bookingConfirmations->removeElement($bookingConfirmation)) {
            // set the owning side to null (unless already changed)
            if ($bookingConfirmation->getRoom() === $this) {
                $bookingConfirmation->setRoom(null);
            }
        }

        return $this;
    }

}
