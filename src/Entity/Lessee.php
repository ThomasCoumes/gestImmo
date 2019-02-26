<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
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
     * @ORM\Column(type="string", length=255)
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
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=510)
     * @Assert\Type("string")
     * @var string
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
     *      min = 5,
     *      max = 255,
     *      minMessage = "Votre email est trop court",
     *      maxMessage = "Votre email est trop long"
     * )
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Regex("/[0-9]{10}/", message="Veuillez entrer un numéro de telephone valide")
     * @var string
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", inversedBy="lessees")
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
     * @ORM\Column(type="json")
     * @var string
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit faire au moins 8 caracteres",
     * )
     * @Assert\EqualTo(
     *     propertyPath="confirm_password",
     *     message="Vous avez mal ré-entré ce mot de passe dans le champ de confirmation"
     * )
     */
    private $password;

    /**
     * @var string
     */
    private $confirmPassword;

    public function __construct()
    {
        $this->lessee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

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

    public function addLessee(Property $lessee): self
    {
        if (!$this->lessee->contains($lessee)) {
            $this->lessee[] = $lessee;
        }

        return $this;
    }

    public function removeLessee(Property $lessee): self
    {
        if ($this->lessee->contains($lessee)) {
            $this->lessee->removeElement($lessee);
        }

        return $this;
    }

    public function getUserLessee(): ?User
    {
        return $this->userLessee;
    }

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
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_LESSEE';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
