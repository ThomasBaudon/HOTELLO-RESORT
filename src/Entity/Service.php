<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\SlugTrait;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_service = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameService(): ?string
    {
        return $this->name_service;
    }

    public function setNameService(string $name_service): self
    {
        $this->name_service = $name_service;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getImageService(): ?string
    {
        return $this->image_service;
    }

    public function setImageService(?string $image_service): self
    {
        $this->image_service = $image_service;

        return $this;
    }
}
