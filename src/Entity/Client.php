<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname_client = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname_client = null;

    #[ORM\Column(length: 150)]
    private ?string $adress_client = null;

    #[ORM\Column(length: 50)]
    private ?string $city_client = null;

    #[ORM\Column(length: 10)]
    private ?string $zip_client = null;

    #[ORM\Column(length: 15)]
    private ?string $phone_client = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $birthdate_client = null;

    #[ORM\Column(length: 50)]
    private ?string $country_client = null;

    #[ORM\OneToMany(mappedBy: 'id_client', targetEntity: Review::class)]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastnameClient(): ?string
    {
        return $this->lastname_client;
    }

    public function setLastnameClient(string $lastname_client): self
    {
        $this->lastname_client = $lastname_client;

        return $this;
    }

    public function getFirstnameClient(): ?string
    {
        return $this->firstname_client;
    }

    public function setFirstnameClient(string $firstname_client): self
    {
        $this->firstname_client = $firstname_client;

        return $this;
    }

    public function getAdressClient(): ?string
    {
        return $this->adress_client;
    }

    public function setAdressClient(string $adress_client): self
    {
        $this->adress_client = $adress_client;

        return $this;
    }

    public function getCityClient(): ?string
    {
        return $this->city_client;
    }

    public function setCityClient(string $city_client): self
    {
        $this->city_client = $city_client;

        return $this;
    }

    public function getZipClient(): ?string
    {
        return $this->zip_client;
    }

    public function setZipClient(string $zip_client): self
    {
        $this->zip_client = $zip_client;

        return $this;
    }

    public function getPhoneClient(): ?string
    {
        return $this->phone_client;
    }

    public function setPhoneClient(string $phone_client): self
    {
        $this->phone_client = $phone_client;

        return $this;
    }

    public function getBirthdateClient(): ?\DateTimeInterface
    {
        return $this->birthdate_client;
    }

    public function setBirthdateClient(\DateTimeInterface $birthdate_client): self
    {
        $this->birthdate_client = $birthdate_client;

        return $this;
    }

    public function getCountryClient(): ?string
    {
        return $this->country_client;
    }

    public function setCountryClient(string $country_client): self
    {
        $this->country_client = $country_client;

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
            $review->setIdClient($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getIdClient() === $this) {
                $review->setIdClient(null);
            }
        }

        return $this;
    }
}
