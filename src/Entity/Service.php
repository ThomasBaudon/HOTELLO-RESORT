<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use Doctrine\DBAL\Types\Types;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;


#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[Uploadable]
class Service
{
    use SlugTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

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

    #[UploadableField(mapping: 'services_images', fileNameProperty: 'image_service')]
    private ?File $roomImages = null;

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

    public function getRoomImages(): ?File
    {
        return $this->roomImages;
    }

    public function setRoomImages(?File $roomImages): self
    {
        $this->roomImages = $roomImages;

        if ($this->roomImages instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable('now');
        }

        return $this;
    }
}
