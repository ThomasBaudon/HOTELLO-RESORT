<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'equipment')]
    private ?Room $id_room = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_equipment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRoom(): ?Room
    {
        return $this->id_room;
    }

    public function setIdRoom(?Room $id_room): self
    {
        $this->id_room = $id_room;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
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

    public function setDescriptionEquipment(?string $description_equipment): self
    {
        $this->description_equipment = $description_equipment;

        return $this;
    }
}
