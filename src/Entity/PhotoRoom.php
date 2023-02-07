<?php

namespace App\Entity;

use Stringable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRoomRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: PhotoRoomRepository::class)]
#[Uploadable]
class PhotoRoom implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_photo = null;

    #[UploadableField(mapping: 'other_room_images', fileNameProperty: 'path_photo')]
    private ?File $roomImages = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'photo_room')]
    private ?Room $room = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;
  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPathPhoto(): ?string
    {
        return $this->path_photo;
    }

    public function setPathPhoto(?string $path_photo): self
    {
        $this->path_photo = $path_photo;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->path_photo;
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

    public function getRoomImages(): ?File
    {
        return $this->roomImages;
    }

    public function setRoomImages(?File $roomImages): self
    {
        $this->roomImages = $roomImages;

        if ($this->roomImages instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable();
        }

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
}
