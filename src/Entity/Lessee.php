<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Lessee
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\LesseeRepository")
 */
class Lessee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     * @Assert\Type("string")
     * @Assert\Choice(choices={"Mr", "Mme", "Mlle"},
     *      message="Veuillez choisir votre civilité")
     * @Assert\NotBlank
     * @var string
     */
    private $civility;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Regex("/^[- 'a-zA-ZÀ-ÖØ-öø-ÿ]{0,255}$/")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex("/^[- 'a-zA-ZÀ-ÖØ-öø-ÿ]{0,255}$/")
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=511)
     * @Assert\Type("string")
     * @Assert\Regex("/^[- 'a-zA-ZÀ-ÖØ-öø-ÿ]{0,511}$/")
     * @var string
     */
    private $fullName;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @var string A "d-m-Y" formatted value
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $placeOfBirth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Email(
     *     message = "Veuillez renseigner votre adresse mail.",
     *     checkMX = true
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 255,
     *      minMessage = "Votre email est trop court",
     *      maxMessage = "Votre email est trop long"
     * )
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex("/^[0-9]{10}$/", message="Veuillez entrer un numéro de telephone valide")
     * @var string
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", inversedBy="lessees")
     * @var ArrayCollection
     */
    private $lessee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lessees")
     */
    private $userLessee;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(type="string")
     * @var string
     */
    private $invitationToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RentRelease", mappedBy="rentRelease")
     * @var ArrayCollection
     */
    private $rentReleases;

    /**
     * Lessee constructor.
     */
    public function __construct()
    {
        $this->lessee = new ArrayCollection();
        $this->rentReleases = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     * @return Lessee
     */
    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Lessee
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Lessee
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @param \DateTimeInterface $birthday
     * @return Lessee
     */
    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     * @return Lessee
     */
    public function setPlaceOfBirth(string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Lessee
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return Lessee
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getLessee(): Collection
    {
        return $this->lessee;
    }

    /**
     * @param Property $lessee
     * @return Lessee
     */
    public function addLessee(Property $lessee): self
    {
        if (!$this->lessee->contains($lessee)) {
            $this->lessee[] = $lessee;
        }

        return $this;
    }

    /**
     * @param Property $lessee
     * @return Lessee
     */
    public function removeLessee(Property $lessee): self
    {
        if ($this->lessee->contains($lessee)) {
            $this->lessee->removeElement($lessee);
        }

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUserLessee(): ?User
    {
        return $this->userLessee;
    }

    /**
     * @param User|null $userLessee
     * @return Lessee
     */
    public function setUserLessee(?User $userLessee): self
    {
        $this->userLessee = $userLessee;

        return $this;
    }

    /**
     * @return string or null
     */
    public function getInvitationToken(): ?string
    {
        return $this->invitationToken;
    }

    /**
     * @param string $invitationToken
     */
    public function setInvitationToken(?string $invitationToken)
    {
        $this->invitationToken = $invitationToken;
    }

    /**
     * @return Collection|RentRelease[]
     */
    public function getRentReleases(): Collection
    {
        return $this->rentReleases;
    }

    /**
     * @param RentRelease $rentRelease
     * @return Lessee
     */
    public function addRentRelease(RentRelease $rentRelease): self
    {
        if (!$this->rentReleases->contains($rentRelease)) {
            $this->rentReleases[] = $rentRelease;
            $rentRelease->setRentRelease($this);
        }

        return $this;
    }

    /**
     * @param RentRelease $rentRelease
     * @return Lessee
     */
    public function removeRentRelease(RentRelease $rentRelease): self
    {
        if ($this->rentReleases->contains($rentRelease)) {
            $this->rentReleases->removeElement($rentRelease);
            // set the owning side to null (unless already changed)
            if ($rentRelease->getRentRelease() === $this) {
                $rentRelease->setRentRelease(null);
            }
        }

        return $this;
    }
}
