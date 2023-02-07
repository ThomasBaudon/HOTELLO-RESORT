<?php

namespace App\Entity;

use Stringable;
use App\Entity\Room;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[Uploadable]
class Equipment implements Stringable
{

    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[UploadableField(mapping: 'equipment_images', fileNameProperty: 'icon')]
    private ?File $roomIcon = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_equipment = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToMany(targetEntity: Room::class, inversedBy: 'equipment')]
    private Collection $room;

    

    public function __construct()
    {
        $this->room = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescriptionEquipment(): ?string
    {
        return $this->description_equipment;
    }

    public function setDescriptionEquipment(string $description_equipment): self
    {
        $this->description_equipment = $description_equipment;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        $this->room->removeElement($room);

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getRoomIcon(): ?File
    {
        return $this->roomIcon;
    }

    public function setRoomIcon(?File $roomIcon): self
    {
        $this->roomIcon = $roomIcon;

        if ($this->roomIcon instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable('now');
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->icon;
    }
}
