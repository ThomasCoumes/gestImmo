<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $propertyType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $uniqueName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zipCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $surfaceInSquarMeter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $numberOfPiece;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     */
    private $equipment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rentalType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rentExcludingCharge;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $charges;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchasePrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyType(): ?User
    {
        return $this->propertyType;
    }

    public function setPropertyType(?User $propertyType): self
    {
        $this->propertyType = $propertyType;

        return $this;
    }

    public function getUniqueName(): ?User
    {
        return $this->uniqueName;
    }

    public function setUniqueName(?User $uniqueName): self
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    public function getAddress(): ?User
    {
        return $this->address;
    }

    public function setAddress(?User $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?User
    {
        return $this->city;
    }

    public function setCity(?User $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?User
    {
        return $this->zipCode;
    }

    public function setZipCode(?User $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?User
    {
        return $this->country;
    }

    public function setCountry(?User $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getSurfaceInSquarMeter(): ?User
    {
        return $this->surfaceInSquarMeter;
    }

    public function setSurfaceInSquarMeter(?User $surfaceInSquarMeter): self
    {
        $this->surfaceInSquarMeter = $surfaceInSquarMeter;

        return $this;
    }

    public function getNumberOfPiece(): ?User
    {
        return $this->numberOfPiece;
    }

    public function setNumberOfPiece(?User $numberOfPiece): self
    {
        $this->numberOfPiece = $numberOfPiece;

        return $this;
    }

    public function getDescription(): ?User
    {
        return $this->description;
    }

    public function setDescription(?User $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * @return mixed
     */
    public function getRentalType()
    {
        return $this->rentalType;
    }

    /**
     * @param mixed $rentalType
     */
    public function setRentalType($rentalType)
    {
        $this->rentalType = $rentalType;
    }

    /**
     * @return mixed
     */
    public function getRentExcludingCharge()
    {
        return $this->rentExcludingCharge;
    }

    /**
     * @param mixed $rentExcludingCharge
     */
    public function setRentExcludingCharge($rentExcludingCharge)
    {
        $this->rentExcludingCharge = $rentExcludingCharge;
    }

    /**
     * @return mixed
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param mixed $charges
     */
    public function setCharges($charges)
    {
        $this->charges = $charges;
    }

    /**
     * @return mixed
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * @param mixed $purchasePrice
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;
    }
}
