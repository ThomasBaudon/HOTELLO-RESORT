<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ContactRepository;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{

    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname_contact = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname_contact = null;

    #[ORM\Column(length: 120)]
    private ?string $email_contact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message_contact = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastnameContact(): ?string
    {
        return $this->lastname_contact;
    }

    public function setLastnameContact(string $lastname_contact): self
    {
        $this->lastname_contact = $lastname_contact;

        return $this;
    }

    public function getFirstnameContact(): ?string
    {
        return $this->firstname_contact;
    }

    public function setFirstnameContact(string $firstname_contact): self
    {
        $this->firstname_contact = $firstname_contact;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->email_contact;
    }

    public function setEmailContact(string $email_contact): self
    {
        $this->email_contact = $email_contact;

        return $this;
    }

    public function getMessageContact(): ?string
    {
        return $this->message_contact;
    }

    public function setMessageContact(string $message_contact): self
    {
        $this->message_contact = $message_contact;

        return $this;
    }
}
