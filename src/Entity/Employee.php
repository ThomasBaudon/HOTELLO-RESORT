<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\UpdatedAtTrait;
use App\Repository\EmployeeRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[Uploadable]
class Employee
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname_employee = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname_employee = null;

    #[ORM\Column(length: 50)]
    private ?string $job_employee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_employee = null;

    #[UploadableField(mapping: 'employees', fileNameProperty: 'photo_employee')]
    private ?File $employePicFile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $arrival_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastnameEmployee(): ?string
    {
        return $this->lastname_employee;
    }

    public function setLastnameEmployee(string $lastname_employee): self
    {
        $this->lastname_employee = $lastname_employee;

        return $this;
    }

    public function getFirstnameEmployee(): ?string
    {
        return $this->firstname_employee;
    }

    public function setFirstnameEmployee(string $firstname_employee): self
    {
        $this->firstname_employee = $firstname_employee;

        return $this;
    }

    public function getJobEmployee(): ?string
    {
        return $this->job_employee;
    }

    public function setJobEmployee(string $job_employee): self
    {
        $this->job_employee = $job_employee;

        return $this;
    }

    public function getPhotoEmployee(): ?string
    {
        return $this->photo_employee;
    }

    public function setPhotoEmployee(?string $photo_employee): self
    {
        $this->photo_employee = $photo_employee;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTimeInterface $arrival_date): self
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }


    public function getEmployePicFile()
    {
        return $this->employePicFile;
    }


    public function setEmployePicFile($employePicFile)
    {
        $this->employePicFile = $employePicFile;

        if ($this->employePicFile instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable('now');
        }

        return $this;
    }
}
