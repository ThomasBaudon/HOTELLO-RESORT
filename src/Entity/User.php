<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Entity\Trait\CreatedAtTrait;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?string $lastname_user = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname_user = null;

    #[ORM\Column(length: 150)]
    private ?string $adress_user = null;

    #[ORM\Column(length: 50)]
    private ?string $city_user = null;

    #[ORM\Column(length: 10)]
    private ?string $zip_user = null;

    #[ORM\Column(length: 15)]
    private ?string $phone_user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $birthdate_user = null;

    #[ORM\Column(length: 50)]
    private ?string $country_user = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Review::class)]
    private Collection $reviews;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->roles = ['ROLE_USER'];
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

    public function getLastnameUser(): ?string
    {
        return $this->lastname_user;
    }

    public function setLastnameUser(string $lastname_user): self
    {
        $this->lastname_user = $lastname_user;

        return $this;
    }

    public function getFirstnameUser(): ?string
    {
        return $this->firstname_user;
    }

    public function setFirstnameUser(string $firstname_user): self
    {
        $this->firstname_user = $firstname_user;

        return $this;
    }

    public function getAdressUser(): ?string
    {
        return $this->adress_user;
    }

    public function setAdressUser(string $adress_user): self
    {
        $this->adress_user = $adress_user;

        return $this;
    }

    public function getCityUser(): ?string
    {
        return $this->city_user;
    }

    public function setCityUser(string $city_user): self
    {
        $this->city_user = $city_user;

        return $this;
    }

    public function getZipUser(): ?string
    {
        return $this->zip_user;
    }

    public function setZipUser(string $zip_user): self
    {
        $this->zip_user = $zip_user;

        return $this;
    }

    public function getPhoneUser(): ?string
    {
        return $this->phone_user;
    }

    public function setPhoneUser(string $phone_user): self
    {
        $this->phone_user = $phone_user;

        return $this;
    }

    public function getBirthdateUser(): ?\DateTimeInterface
    {
        return $this->birthdate_user;
    }

    public function setBirthdateUser(\DateTimeInterface $birthdate_user): self
    {
        $this->birthdate_user = $birthdate_user;

        return $this;
    }

    public function getCountryUser(): ?string
    {
        return $this->country_user;
    }

    public function setCountryUser(string $country_user): self
    {
        $this->country_user = $country_user;

        return $this;
    }

    // /**
    //  * @return Collection<int, Review>
    //  */
    // public function getReviews(): Collection
    // {
    //     return $this->reviews;
    // }

    // public function addReview(Review $review): self
    // {
    //     if (!$this->reviews->contains($review)) {
    //         $this->reviews->add($review);
    //         $review->setIdUser($this);
    //     }

    //     return $this;
    // }

    // public function removeReview(Review $review): self
    // {
    //     if ($this->reviews->removeElement($review)) {
    //         // set the owning side to null (unless already changed)
    //         if ($review->getIdUser() === $this) {
    //             $review->setIdUser(null);
    //         }
    //     }

    //     return $this;
    // }

    // public function getUser(): ?User
    // {
    //     return $this->user;
    // }

    // public function setUser(User $user): self
    // {
    //     // set the owning side of the relation if necessary
    //     if ($user->getId() !== $this) {
    //         $user->setId($this);
    //     }

    //     $this->user = $user;

    //     return $this;
    // }
}
