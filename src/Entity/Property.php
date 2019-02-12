<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uniqueName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     * @Assert\Length(min = 5, minMessage = "Ce champ doit contenir 5 chiffres")
     * @Assert\Length(max = 5, maxMessage = "Ce champ doit contenir 5 chiffres")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Country
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $surfaceInSquareMeter;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $numberOfPiece;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Choice({"Meublé", "Non neublé"})
     */
    private $rentalCategory;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private $rentExcludingCharges;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private $charges;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Type("float")
     */
    private $purchasePrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     */
    private $userProperty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipment", mappedBy="equipment")
     */
    private $equipments;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyCategory(): ?string
    {
        return $this->propertyCategory;
    }

    public function setPropertyCategory(string $propertyCategory): self
    {
        $this->propertyCategory = $propertyCategory;

        return $this;
    }

    public function getUniqueName(): ?string
    {
        return $this->uniqueName;
    }

    public function setUniqueName(string $uniqueName): self
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getSurfaceInSquareMeter(): ?int
    {
        return $this->surfaceInSquareMeter;
    }

    public function setSurfaceInSquareMeter(int $surfaceInSquareMeter): self
    {
        $this->surfaceInSquareMeter = $surfaceInSquareMeter;

        return $this;
    }

    public function getNumberOfPiece(): ?int
    {
        return $this->numberOfPiece;
    }

    public function setNumberOfPiece(int $numberOfPiece): self
    {
        $this->numberOfPiece = $numberOfPiece;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRentalCategory(): ?string
    {
        return $this->rentalCategory;
    }

    public function setRentalCategory(string $rentalCategory): self
    {
        $this->rentalCategory = $rentalCategory;

        return $this;
    }

    public function getRentExcludingCharges(): ?float
    {
        return $this->rentExcludingCharges;
    }

    public function setRentExcludingCharges(float $rentExcludingCharges): self
    {
        $this->rentExcludingCharges = $rentExcludingCharges;

        return $this;
    }

    public function getCharges(): ?float
    {
        return $this->charges;
    }

    public function setCharges(float $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getUserProperty(): ?User
    {
        return $this->userProperty;
    }

    public function setUserProperty(?User $userProperty): self
    {
        $this->userProperty = $userProperty;

        return $this;
    }

    /**
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setEquipment($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->contains($equipment)) {
            $this->equipments->removeElement($equipment);
            // set the owning side to null (unless already changed)
            if ($equipment->getEquipment() === $this) {
                $equipment->setEquipment(null);
            }
        }

        return $this;
    }
}
