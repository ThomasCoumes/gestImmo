<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="{{ value }} n'est pas un nombre entier."
     * )
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Email(
     *     message = "Veuillez renseigner votre adresse mail.",
     *     checkMX = true
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 180,
     *      minMessage = "Votre email est trop court",
     *      maxMessage = "Votre email est trop long"
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="Role invalide."
     * )
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Votre mot de passe doit faire au moins 8 caracteres",
     * )
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 180,
     *      minMessage = "Votre prénom est trop court",
     *      maxMessage = "Votre prénom est trop long"
     * )
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} doit etre une chaine de caractères."
     * )
     * @Assert\Length(
     *      min = 5,
     *      max = 180,
     *      minMessage = "Votre nom est trop court",
     *      maxMessage = "Votre nom est trop long"
     * )
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Property", mappedBy="propertyType")
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
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
    public function getUsername(): string
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): string
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName): string
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setPropertyType($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getPropertyType() === $this) {
                $property->setPropertyType(null);
            }
        }

        return $this;
    }
}
